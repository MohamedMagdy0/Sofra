<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('address', 'total', 'net' , 'delivery_fee', 'total_price', 'state', 'app_commission', 'client_id', 'restaurant_id', 'payment_method_id');

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'payment_method_id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item')->withPivot('price','quantity','notes');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

}
