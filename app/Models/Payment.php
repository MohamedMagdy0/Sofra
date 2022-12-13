<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('date_of_paid', 'paid', 'notes', 'restaurant_id', 'order_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

}