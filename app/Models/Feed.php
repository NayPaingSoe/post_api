<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    protected $fillable=['user_id','description','image'];

    //mutator
// public function getArrtibute($value)
// {
//     return ucFirst($value);
// }
//accessor
// public function setNameAttribute($$value)
// {
//     $this->attributes['name']="Mr".$$value;
// }
public function setNameAttribute($value)
{
    $this->attributes['name']="Mr".$value;
}

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment','feed_id');
    }
    public function likes()
    {
        return $this->hasMany('App\Models\Comment', 'feed_id');
    }
}