<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Survey;
use Illuminate\Support\Facades\Storage;

class ExportSurveyResultsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $surveyId;
    protected $format;
    protected $userId;

    public function __construct($surveyId, $format, $userId)
    {
        $this->surveyId = $surveyId;
        $this->format = $format;
        $this->userId = $userId;
    }

    public function handle()
    {
        $survey = Survey::find($this->surveyId);
        if (!$survey) {
            return;
        }

        $fileName = "exports/survey_report_{$this->surveyId}_" . time() . ".{$this->format}";
        $data = $survey->sessions()->with('answers')->get()->toJson(JSON_UNESCAPED_UNICODE);

        Storage::disk('public')->put($fileName, $data);
    }
}
