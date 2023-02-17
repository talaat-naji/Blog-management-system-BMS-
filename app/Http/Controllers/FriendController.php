<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index(Request $request){
        $friend=new Friend();
        $id=Auth()->id();
    $recordExist=Friend::where('user_id_1','=',$id)
                        ->where('user_id_2','=',$request->toBeAdded)
                        ->count('id');

        if($recordExist >0){
            Friend::where('user_id_1','=',$id)
            ->where('user_id_2','=',$request->toBeAdded)
            ->delete();
       
        }else{
            $friend->user_id_1=$id;
        $friend->user_id_2=$request->toBeAdded;
        $friend->save();
       }

        $Approved=Friend::where('user_id_1','=',$id)
        ->where('user_id_2','=',$request->toBeAdded)
        ->select('approved')->get();
      
return $Approved;        

    }

    public function followStat(Request $request){
        $friend=new Friend();
        $id=Auth()->id();
    

        $Approved=Friend::where('user_id_1','=',$id)
        ->where('user_id_2','=',$request->toBeChecked)
        ->select('approved')->get();
       
return $Approved;        

    }
}
