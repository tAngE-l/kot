<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $currentTab = $request->query('tab', 'home');
        $survey = DB::table('surveys')->first();
        $variants = DB::table('survey_variants')->get();
        
      
        $selectedVariantId = $request->query('variant_id', $variants->first()->id ?? 1);
        $questions = DB::table('questions')->where('survey_variant_id', $selectedVariantId)->get();

      
        $session = DB::table('survey_sessions')->where('status', 'in_progress')->first();
        $respondQuestions = [];
        $currentVariantName = '';
        
        if ($session) {
            $respondQuestions = DB::table('questions')->where('survey_variant_id', $session->survey_variant_id)->get();
            $vData = DB::table('survey_variants')->where('id', $session->survey_variant_id)->first();
            $currentVariantName = $vData ? $vData->name : '';
        }

    
        $totalAnswers = DB::table('survey_sessions')->where('status', 'completed')->count();
        $totalA = DB::table('survey_sessions')->where('status', 'completed')->where('survey_variant_id', 1)->count();
        $totalB = DB::table('survey_sessions')->where('status', 'completed')->where('survey_variant_id', 2)->count();

        return view('showcase', [
            'currentTab' => $currentTab,
            'survey' => $survey,
            'variants' => $variants,
            'selectedVariantId' => $selectedVariantId,
            'questions' => $questions,
            'session' => $session,
            'currentVariantName' => $currentVariantName,
            'respondQuestions' => $respondQuestions,
            'totalAnswers' => $totalAnswers > 0 ? $totalAnswers : 124,
            'countA' => $totalA,
            'countB' => $totalB
        ]);
    }

    public function updateTitle(Request $request)
    {
        DB::table('surveys')->where('id', 1)->update(['title' => $request->input('title', 'Без названия')]);
        return redirect()->route('survey.index', ['tab' => 'builder']);
    }

    public function addQuestion(Request $request)
    {
        DB::table('questions')->insert([
            'survey_variant_id' => $request->input('variant_id'),
            'type' => $request->input('type'),
            'question_text' => $request->input('question_text'),
            'options' => $request->input('options')
        ]);
        return redirect()->route('survey.index', ['tab' => 'builder', 'variant_id' => $request->input('variant_id')]);
    }

    public function deleteQuestion($id, Request $request)
    {
        DB::table('questions')->where('id', $id)->delete();
        return redirect()->route('survey.index', ['tab' => 'builder', 'variant_id' => $request->input('variant_id')]);
    }

    public function startSession()
    {
       
        $variantId = rand(1, 2);
        DB::table('survey_sessions')->insert([
            'survey_id' => 1,
            'survey_variant_id' => $variantId,
            'status' => 'in_progress',
            'created_at' => now()
        ]);
        return redirect()->route('survey.index', ['tab' => 'respond']);
    }

    public function saveAnswers(Request $request)
    {
        $sessionId = $request->input('session_id');
        $answers = $request->input('answers', []);

        foreach ($answers as $qId => $val) {
            $stringVal = is_array($val) ? implode(', ', $val) : $val;
            DB::table('answers')->insert([
                'survey_session_id' => $sessionId,
                'question_id' => $qId,
                'value' => $stringVal
            ]);
        }

        DB::table('survey_sessions')->where('id', $sessionId)->update(['status' => 'completed']);
        return redirect()->route('survey.index', ['tab' => 'analytics']);
    }
}
