<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Quiz;
use App\Http\Resources\QuizResource;
use Illuminate\Support\Facades\Validator;

class QuizController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $quizes = Quiz::with('questions.options');

        if ($quizes->count() == 0) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Quiz Not Found!',
                'data' => []
            ]);
        }

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => QuizResource::collection($quizes->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->respondValidatorError([
                'success' => false,
                'errors' => $validator->errors(),
                'data' => []
            ]);
        }

        $question = Quiz::saveQuiz($request);

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new QuizResource($question)
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
        $quiz = Quiz::where('uuid', $id)->first();
        if (empty($quiz)) {
            return $this->respondNotFound([
                'status' => false,
                'message' => 'Quiz Not Found',
                'data' =>  []
            ]);
        }

        $result = Quiz::updateQuiz($request, $quiz);

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new QuizResource($result)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::where('uuid', $id)->first();

        if (empty($quiz)) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Quizzes Not Found!',
                'data' => []
            ]);
        }

        $quiz->forceDelete();
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => []
        ]);
    }
}
