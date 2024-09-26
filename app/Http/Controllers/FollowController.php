<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function createFollow(User $user){
        if ($user->id == Auth::user()->id) {
            return back()->with('error' , 'You cannot follow yourself.');
        }
        $existCheck = Follow::where([['user_id','=',Auth::user()->id],['followeduser','=', $user->id]])->count();
        if($existCheck){
            return back()->with('error','You are already following this user');
        }
        $newFollow =new Follow;
        $newFollow->user_id =Auth::user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();
        

        return back()->with('success','You are now following this user');

    }

    
    public function removeFollow(User $user){
        Follow::where([['user_id','=',Auth::user()->id],['followeduser', '=', $user->id]])->delete();
      return back()->with('success','You have unfollowed this user');
    
    }
}
