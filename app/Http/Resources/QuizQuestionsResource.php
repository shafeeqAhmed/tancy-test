<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\QuizQuestionOptionsResource;


class QuizQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->resource->uuid,
            'title' => $this->resource->title,
            'reply' => $this->resource->reply,
            'description' => $this->resource->description,
            'options' =>  QuizQuestionOptionsResource::collection($this->resource->options),
        ];
    }
}
