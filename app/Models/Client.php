<?php

namespace App\Models;

use App\Models\Token;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Model
{
    use Notifiable;


    protected $table = 'clients';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'email', 'phone', 'password', 'image', 'is_active', 'api_token', 'pin_code', 'district_id');

########################
  // accessors & mutators
    protected $appends = array('Image_Full_Path');

    public function getImageFullPathAttribute($value)
    {
        return asset($this->image);
    } // getImageFullPathAttribute

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    } // setPasswordAttribute
##################
 
    public function notifications()
    {
        return $this->morphToMany('App\Models\Notification','notifiable');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function tokens()
    {
        return $this->morphMany(Token::class, 'model');
    }


    protected $hidden = [
        'password',
        'api_token',
    ];

}
