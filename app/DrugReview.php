<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugReview extends Model
{
    protected $table = 'drug_reviews';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function drug()
    {
        return $this->belongsTo('App\Drug');
    }

    public function sideEffects()
    {
        return $this->belongsToMany('App\DrugSideEffect');
    }
}