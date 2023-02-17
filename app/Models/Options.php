<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Quiz;

class Options extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'quiz_question_id', 'is_correct'];
    protected $table = 'quiz_question_options';
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public static function updateOptions($request, $question)
    {

        $question_options_arr = array();

        $question_options = self::where('quiz_question_id',  $question->id);
        if ($question_options->count() > 0) {

            $question_options->forceDelete();
        }
        foreach ($request->options as $i => $option) {
            $question_options_arr[$i]['uuid'] = Str::uuid()->toString();
            $question_options_arr[$i]['name'] = $option['name'];
            $question_options_arr[$i]['is_correct'] = $option['is_correct'];
            $question_options_arr[$i]['quiz_question_id'] = $question->id;
        }

        self::insert($question_options_arr);
    }
}
