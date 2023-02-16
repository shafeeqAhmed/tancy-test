<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\QuizQuestionOptions;
use App\Models\QuizQuestions;
use App\Http\Resources\QuizQuestionsResource;

class QuizController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $questions = QuizQuestions::with('options')->where('user_id', $request->user()->id);

        if ($questions->count() == 0) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Questions Not Found!',
                'data' => []
            ]);
        }
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => QuizQuestionsResource::collection($questions->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $question = QuizQuestions::saveQuestion($request);


        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new QuizQuestionsResource($question)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $question = QuizQuestions::where([['uuid', $id], ['user_id', $request->user()->id]])->first();

        if (empty($question)) {
            return $this->respond([
                'status' => false,
                'message' => 'Quiz Question Not Found',
                'data' =>  []
            ]);
        }
        $question = QuizQuestions::updateQuestion($request, $question);

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new QuizQuestionsResource($question)
        ]);
    }

    public function updateQuestionOptions(Request $request)
    {
        $question = QuizQuestions::where('uuid', $request->uuid)->first();

        if (empty($question)) {
            return $this->respond([
                'status' => false,
                'message' => 'Quiz Question Not Found',
                'data' =>  []
            ]);
        }

        $result = QuizQuestionOptions::updateQuizQuestionOptions($request, $question);


        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => []
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = QuizQuestions::where('uuid', $id)->first();

        if (empty($question)) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Question Not Found!',
                'data' => []
            ]);
        }

        $question->forceDelete();
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => []
        ]);
    }


    public function deleteQuestionOption($id)
    {
        $question = QuizQuestionOptions::where('uuid', $id)->first();

        if (empty($question)) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Question Option Not Found!',
                'data' => []
            ]);
        }

        $question->forceDelete();
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => []
        ]);
    }
}
