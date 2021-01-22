<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $guarded = [];

    public function answers() {
        return $this->belongsToMany(
            Answer::class,
            'records_answers',
            'records_id',
            'answers_id');
    }
}
