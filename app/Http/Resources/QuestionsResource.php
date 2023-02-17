<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OptionsResource;


class QuestionsResource extends JsonResource
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
            'is_mandatory' => $this->resource->is_mandatory,
            'description' => $this->resource->description,
            'options' =>  OptionsResource::collection($this->resource->options),
        ];
    }
}
