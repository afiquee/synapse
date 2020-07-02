<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Customer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'phone', 'name', 'email','address','postcode','city','state_id','created_at','created_by'
    ];

    protected $casts = [
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
