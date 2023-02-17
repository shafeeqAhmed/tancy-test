<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Quiz;
use App\Models\Questions;
use App\Models\Options;
use App\Http\Resources\QuestionsResource;

class QuestionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $request->validate([
            'quiz_uuid' => 'required',
        ]);

        $id = Quiz::getIdByUuid($request->quiz_uuid);
        $questions = Questions::with('options')->where('quiz_id', $id);

        if ($questions->count() == 0) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Question and Answers Not Found!',
                'data' => []
            ]);
        }
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => QuestionsResource::collection($questions->get())
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
        $quiz_id = Quiz::getIdByUuid($request->quiz_uuid);

        if (empty($quiz_id)) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Quiz Not Found!',
                'data' => []
            ]);
        }

        $question = Questions::saveQuestion($request, $quiz_id);

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new QuestionsResource($question)
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

        $question = Questions::where('uuid', $id)->first();

        if (empty($question)) {
            return $this->respond([
                'status' => false,
                'message' => 'Question Not Found',
                'data' =>  []
            ]);
        }
        $question = Questions::updateQuestion($request, $question);

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new QuestionsResource($question)
        ]);
    }


    public function updateOptions(Request $request)
    {
        $id = Quiz::getIdByUuid($request->quiz_uuid);
        $question = Questions::where([['uuid', $request->uuid], ['quiz_id', $id]])->first();

        if (empty($question)) {
            return $this->respond([
                'status' => false,
                'message' => 'Question Not Found',
                'data' =>  []
            ]);
        }

        $result = Options::updateOptions($request, $question);


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
        $question = Questions::where('uuid', $id)->first();

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


    public function deleteOption($id)
    {

        $question = Options::where('uuid', $id)->first();

        if (empty($question)) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Option Not Found!',
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
