<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifiable extends Model
{

    protected $table = 'notifiables';
    public $timestamps = true;
    protected $fillable = array('notification_id', 'notifiable_id', 'notifiable_type');

}
