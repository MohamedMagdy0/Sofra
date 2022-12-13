<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{

    protected $table = 'items';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'description', 'price', 'sale_price', 'notes', 'service_time', 'image', 'category_id', 'restaurant_id');

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }

}
