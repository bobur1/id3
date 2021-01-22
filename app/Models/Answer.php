<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    /**
     * Get the question.
     */
    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'policy_series_id');
    }

    public function records() {
        return $this->belongsToMany(
            Record::class,
            'records_answers',
            'answers_id',
            'records_id');
    }
}
