<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;
use App\Models\Options;
use Illuminate\Database\Eloquent\SoftDeletes;


class Questions extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'reply', 'description', 'quiz_id', 'is_mandatory'];
    protected $table = 'quiz_questions';
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
        return $this->hasMany(Options::class, 'quiz_question_id', 'id');
    }

    public static function saveQuestion($request, $quiz_id)
    {

        $question = new Questions($request->except('quiz_uuid'));
        $question->quiz_id = $quiz_id;
        $question->save();
        return $question;
    }

    public static function updateQuestion($request, $question)
    {
        $question->title = $request->title;
        $question->reply = $request->reply;
        $question->description = $request->description;
        $question->is_mandatory = $request->is_mandatory;
        $question->save();
        return $question;
    }
}
