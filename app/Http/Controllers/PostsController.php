<?php

namespace App\Http\Controllers;

use App\Models\posts;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostsController extends Controller
{
// loading posts posted by the users you follow
  public function followingPosts(Request $request){
    
    $posts= DB::table('posts')
    ->leftJoin('users','posts.user_id','=','users.id')
    ->leftjoin('friends', 'posts.user_id','=', 'friends.user_id_2')
    ->where('friends.user_id_1','=',Auth::id()) 
    ->select('posts.*','users.id as uid','users.name')
    ->latest()->simplePaginate(2);
   
  return view('followingPosts',compact('posts'));
 }
 // loading posts posted by the logged in user
  public function showProfile(Request $request){

    $posts= DB::table('posts')
    ->where('posts.user_id','=',$request->profId)
    ->leftJoin('users','posts.user_id','=','users.id')
    ->select('posts.*','users.id as uid','users.name')
    ->latest()->get();
    $userId=['us'=>$request->profId];
    
   
   return view('usProfile',compact('posts'),compact('userId'));
 }
  // loading posts for the public view before logging in
  public function publicshowPosts(){
   
 
        $posts= DB::table('posts')
        ->leftJoin('users','posts.user_id','=','users.id')     
        ->select('posts.*','users.id as uid','users.name')
        ->groupBy('posts.id')
        ->latest()->paginate(5);
    
      return view('welcome',compact('posts'));
     }
// loading all posts for feed view
  public function showPosts(Request $request){
    
       $posts= DB::table('posts')
       ->leftJoin('users','posts.user_id','=','users.id')
       ->select('posts.*','users.id as uid','users.name')
       ->latest()->simplePaginate(2);
      
     return view('feed',compact('posts'));
    }
// SEARCH POST
    public function searchPost(Request $request){
  
      // get input text
    $post_title=$request->search_input;
    
      $postt= Posts::where('posts.title','=',$post_title)
      ->leftJoin('users','posts.user_id','=','users.id')
      ->select('posts.*','users.id as uid','users.name')
      ->get();
    
    return view('post',compact('postt'));
  
   }
// DELETE POST
  public function delPosts(Request $request){
    $imagepath='var/www/bloggApp/storage/app/'.$request->pic;
    if($imagepath!="var/www/bloggApp/storage/app/"){
     
    if(Storage::exists($imagepath)){
      
      Storage::delete($imagepath);
    }
  }
        $postdel=$request->pstId;
       
       posts::destroy($postdel);
       return redirect('/feeds');
     }
   
     // ADDING A POST
  public function addPosts(Request $request){

      $request->validate([
        'title'=>'required',
          'blog_text' =>'required',
          'pic_path' => 'nullable|image'
      ]);
      if($request->file('imgg')!=null){
      $file_namewithExt= $request->file('imgg')->getClientOriginalName();

   $path=$request->file('imgg')->storeAs('/storage', $file_namewithExt);

      }else{$path='';}
      $form_data=array(
          'user_id'=>Auth::id(),
          'title'=>$request->title,
          'blog_text'=>$request->blog_text,
          'pic_path'=>$path
      );
      posts::create($form_data);
     return redirect('/feeds');
     }

     //EDITING POST TEXT
  public function editText(Request $request){

          $user_id=Auth::id();
          $new_text=$request->new_text;
          $post_id=$request->post_id;
       
      
      posts::where('posts.id',$post_id)
      ->where('posts.user_id',$user_id)
      ->update(['blog_text'=>$new_text]);
     }

}
