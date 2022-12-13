<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    // use Notifiable;

    protected $table = 'notifications';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('title', 'content', 'order_id');

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function restaurants()
    {
        return $this->morphedByMany(Resturant::class);
    }

    public function clients()
    {
       return $this->morphedByMany(Client::class);
    }

}
