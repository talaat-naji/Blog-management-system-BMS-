<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    use HasFactory;

    protected $table='posts';
    protected $fillable=['user_id','title','blog_text','pic_path'];

    public function user(){
        return $this->belongsto('App/User');
    }
}
