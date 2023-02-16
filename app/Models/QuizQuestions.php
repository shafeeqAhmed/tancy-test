<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;
use App\Models\QuizQuestionOptions;
use Illuminate\Database\Eloquent\SoftDeletes;


class QuizQuestions extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'reply', 'description', 'user_id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function options()
    {
        return $this->hasMany(QuizQuestionOptions::class, 'quiz_question_id', 'id');
    }

    public static function saveQuestion($request)
    {
        $question = new QuizQuestions($request->all());
        $question->user_id = $request->user()->id;
        $question->save();
        return $question;
    }

    public static function updateQuestion($request, $question)
    {

        $question->title = $request->title;
        $question->reply = $request->reply;
        $question->description = $request->description;
        $question->save();
        return $question;
    }
}
