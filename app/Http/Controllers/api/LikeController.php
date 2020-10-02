<?php

namespace App\Http\Controllers\api;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function like()
    {
        $v=Validator::make(request()->all(),[
            'feed_id'=>'required'
            ]);
            if ($v->fails()) {
                return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$v->errors()
                     ]);
             }
            $feed_id=request()->feed_id;
            $user_id=Auth::id();
           if ($this->isalreadyLike($user_id,$feed_id)){
            return response()->json([
                        'status'=>500,
                        'message'=>'fails',
                        'data'=>'you cannot like agian',
                    ]);
           }

            $like=Like::create([
                'feed_id'=>$feed_id,
                'user_id'=>$user_id
            ]);
            return response()->json([
                        'status'=>200,
                        'message'=>'success'
                    ]);       
    }
    public function isalreadyLike($user_id,$feed_id)
    {
        $alreadylike=Like::where('user_id',$user_id)
                        ->where('feed_id',$feed_id)->count();
        return $alreadylike;
    }
}
