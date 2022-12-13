<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model 
{

    protected $table = 'reviews';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'comment', 'rating', 'client_id', 'restaurant_id');

    public function clients()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function restaurants()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

}