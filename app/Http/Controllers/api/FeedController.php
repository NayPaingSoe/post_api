<?php

namespace App\Http\Controllers\api;

use App\Models\Feed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{
    public function create()
    {
        
        $v=Validator::make(request()->all(),[
            'description'=>'required|min:1',
            'image'=>'mimes:jpg,png,jpeg']);
            if ($v->fails()) {
                return response()->json([
                'status'=>500,
                'message'=>'fail',
                'data'=>$v->errors()
         ]);
        }

        $image=request()->image;    
      $image_name=uniqid().$image->getClientOriginalName();
      $image->move('feed',$image_name);
        $feed=Feed::create([
            'description'=>request()->description,
            'image'=>'/feed/'.$image_name,
            'user_id'=>Auth::id(),
            ]);
        return response()->json([
                    'status'=>200,
                    'message'=>'success',
                    'data'=>$feed,
                ]);
    }
    public function feed()
    {
        $feed=Feed::orderBy('id','DESC')->with('user')->paginate(10);
        return response()->json([
                    'status'=>200,
                    'message'=>'success',
                    'data'=>$feed,
                ]);
    }
    public function delete()
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
        $feed_id= request()->feed_id;
        $uerid=Auth::id();
        $feed=Feed::where('id',$feed_id)
                    ->where('user_id',$uerid)->delete();
       
        if ($feed) {
            return response()->json([
                        'status'=>200,
                        'message'=>'success',
                        'data'=>'You  delete your feed'
                    ]);
        }
        return response()->json([
                    'status'=>500,
                    'message'=>'failed',
                    'data'=>'You cannot delete this feed'
                ]);
    }
    
}
