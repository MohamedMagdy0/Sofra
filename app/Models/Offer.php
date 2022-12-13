<?php

namespace App\Models;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'content', 'image', 'start_date', 'end_date', 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant' , 'restaurant_id');
    }

}
