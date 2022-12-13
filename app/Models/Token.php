<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model 
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = array('token', 'type', 'model_id', 'model_type');

    public function restaurants()
    {
        return $this->morphTo();
    }

    public function clients()
    {
        return $this->morphTo();
    }

}