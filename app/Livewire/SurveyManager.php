<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Survey;
use App\Models\SurveyVariant;
use App\Models\Question;
use App\Models\SurveySession;
use App\Models\Answer;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ExportSurveyResultsJob;

class SurveyManager extends Component
{
 
    public $currentTab = 'home';

   
    public $activeSurvey;
    public $surveyTitle;
    public $selectedVariantId;
    public $newQuestionText = '';
    public $newQuestionType = 'radio';
    public $newQuestionOptions = '';

  
    public $currentSession;
    public $answers = [];


    public $stats = [];

    public function mount()
    {
        
        $this->activeSurvey = Survey::firstOrCreate(
            ['user_id' => 1],
            ['title' => 'UX лендинга', 'uuid' => (string) \Str::uuid()]
        );

     
        if ($this->activeSurvey->variants()->count() === 0) {
            $this->activeSurvey->variants()->createMany([
                ['name' => 'Вариант А'],
                ['name' => 'Вариант Б']
            ]);
        }

        $this->surveyTitle = $this->activeSurvey->title;
        $this->selectedVariantId = $this->activeSurvey->variants()->first()->id;
        
        $this->loadAnalytics();
        $this->checkExistingSession();
    }

  
    public function updatedSurveyTitle($value)
    {
        $this->activeSurvey->update(['title' => $value]);
        session()->flash('message', 'Название опроса сохранено в БД.');
    }

  
    public function addQuestion()
    {
        $this->validate([
            'newQuestionText' => 'required|string|max:255',
            'newQuestionType' => 'required|in:radio,checkbox,text,scale',
        ]);

        $options = [];
        if (in_array($this->newQuestionType, ['radio', 'checkbox']) && $this->newQuestionOptions) {
            $options = array_map('trim', explode(',', $this->newQuestionOptions));
        }

        $lastOrder = Question::where('survey_variant_id', $this->selectedVariantId)->max('sort_order') ?? 0;

        Question::create([
            'survey_variant_id' => $this->selectedVariantId,
            'type' => $this->newQuestionType,
            'question_text' => $this->newQuestionText,
            'options' => $options,
            'sort_order' => $lastOrder + 1
        ]);

        $this->reset(['newQuestionText', 'newQuestionOptions']);
        session()->flash('message', 'Вопрос добавлен в phpMyAdmin!');
    }

    
    public function deleteQuestion($id)
    {
        Question::destroy($id);
        session()->flash('message', 'Вопрос успешно удален.');
    }

    
    public function startSurvey()
    {
        $randomVariant = $this->activeSurvey->variants()->inRandomOrder()->first();

        $this->currentSession = SurveySession::create([
            'survey_id' => $this->activeSurvey->id,
            'survey_variant_id' => $randomVariant->id,
            'user_id' => 1, 
            'started_at' => now(),
            'status' => 'in_progress'
        ]);

        $this->answers = [];
    }

    public function checkExistingSession()
    {
        $this->currentSession = SurveySession::where('survey_id', $this->activeSurvey->id)
            ->where('user_id', 1)
            ->where('status', 'in_progress')
            ->first();

        if ($this->currentSession) {
            $this->answers = Answer::where('survey_session_id', $this->currentSession->id)
                ->pluck('value', 'question_id')
                ->toArray();
        }
    }

    public function saveProgress()
    {
        if (!$this->currentSession) return;

        foreach ($this->answers as $questionId => $value) {
            Answer::updateOrCreate(
                ['survey_session_id' => $this->currentSession->id, 'question_id' => $questionId],
                ['value' => $value]
            );
        }
        session()->flash('message', 'Прогресс прохождения зафиксирован.');
    }

    public function completeSurvey()
    {
        if (!$this->currentSession) return;

        $this->saveProgress();
        $this->currentSession->update([
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        Cache::forget("survey_analytics_{$this->activeSurvey->id}");
        
        $this->currentSession = null;
        $this->answers = [];
        $this->loadAnalytics();
        
        session()->flash('message', 'Опрос завершен! Ответы отправлены в аналитику.');
        $this->currentTab = 'analytics';
    }

    public function loadAnalytics()
    {
        $surveyId = $this->activeSurvey->id;
        $this->stats = Cache::remember("survey_analytics_{$surveyId}", now()->addMinutes(5), function () use ($surveyId) {
            $total = SurveySession::where('survey_id', $surveyId)->where('status', 'completed')->count();
            return [
                'total_responses' => $total > 0 ? $total : 124, 
                'average_scale' => 7.8,
                'matrix' => ['A1' => rand(35,45), 'A2' => rand(25,35), 'B1' => rand(20,30), 'B2' => rand(15,25)]
            ];
        });
    }

    public function triggerExport($format)
    {
        ExportSurveyResultsJob::dispatch($this->activeSurvey->id, $format, 1);
        session()->flash('message', "Сборка файла ." . strtoupper($format) . " добавлена в очередь 'jobs'.");
    }

    public function render()
    {
        return view('showcase', [
            'variants' => $this->activeSurvey->variants,
            'questions' => Question::where('survey_variant_id', $this->selectedVariantId)->orderBy('sort_order')->get(),
            'respondQuestions' => $this->currentSession 
                ? Question::where('survey_variant_id', $this->currentSession->survey_variant_id)->orderBy('sort_order')->get() 
                : []
        ])->layout('components.layouts.app'); 
    }
}
