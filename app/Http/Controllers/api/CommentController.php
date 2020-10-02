<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

class CommentController extends Controller
{
    public function createcomment()
    {
      $v=Validator::make(request()->all(),[
          'feed_id'=>'required',
          'comment'=>'required']);
          if ($v->fails()) {
              return response()->json([
              'status'=>500,
              'message'=>'fail',
              'data'=>$v->errors()
       ]);
        }
        $feed_id=request()->feed_id;
        $comment=request()->comment;
        $comments=Comment::create([
            'feed_id'=>$feed_id,
            'comment'=>$comment,
            'user_id'=>Auth::id()
        ]);
        return response()->json([
                    'status'=>200,
                    'message'=>'success',
                    'data'=>$comments,
                ]);
    }

    public function comments()
    {
        $v=Validator::make(request()->all(),[
            'feed_id'=>'required',
            ]);
            if ($v->fails()) {
                return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$v->errors()
                ]);
            }
        $feed_id=request()->feed_id;
        $comments=Comment::where('feed_id',$feed_id)->get();
        return response()->json([
                    'status'=>200,
                    'message'=>'success',
                    'data'=>$comments,
                ]);
    }
    public function delete()
    {
        $v=Validator::make(request()->all(),[
            'comment_id'=>'required',
            ]);
            if ($v->fails()) {
                return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$v->errors()
                ]);
            }
        $comment_id=request()->comment_id;
        $user_id=Auth::id();
        $commentdel=Comment::where('id',$comment_id)
                ->where('user_id',$user_id)->delete();
        if ($commentdel) {
            return response()->json([
                'status'=>200,
                'message'=>'success',
                'data'=>'Your comment is delete'
            ]);
        }
        return response()->json([
                    'status'=>500,
                    'message'=>'failed',
                    'data'=>'You cannot delete other comment'
                ]);
    }
   




}
