<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;
use App\Models\Questions;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'user_id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public static function getIdByUuid($uuid)
    {
        return self::where('uuid', $uuid)->value('id');
    }

    public function questions()
    {
        return $this->hasMany(Questions::class, 'quiz_id', 'id');
    }

    public static function saveQuiz($request)
    {
        $quiz = new Quiz($request->all());
        $quiz->user_id = $request->user()->id;
        $quiz->save();
        return $quiz;
    }

    public static function updateQuiz($request, $quiz)
    {
        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->save();
        return $quiz;
    }
}
