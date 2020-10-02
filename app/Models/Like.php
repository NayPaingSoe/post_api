<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable=['user_id','feed_id'];


    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function feed()
    {
        return $this->belongsTo('App\Models\Feed','feed_id');
    }
    
}
