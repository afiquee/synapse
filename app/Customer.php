<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Customer extends Model
{
    
    protected $fillable = [
        'phone', 'name', 'email','address','postcode','city','state',
    ];

    protected $casts = [
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
