<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Friend extends Model
{
    use HasFactory;
    public function user1(){
        $this->belongsTo('App\User');
    }
    public function user2(){
        $this->belongsTo('App\User');
    }
}
