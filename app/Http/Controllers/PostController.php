<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Mail\NewPostEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{ 
    public function search($term){
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
    public function actuallyUpdate(Post $post,Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        
        
        $post->update($incomingFields);

        return back()->with('success','Post Successfully Updated.');
    }
    public function showEditForm(Post $post){
        return view ('edit-post',['post'=>$post]);
        
    }
    public function delete(Post $post){
      
        if (Gate::denies('delete', $post)){
            return 'you cannot delete this post';
       }
       $post->delete();

       return redirect('/profile/' . Auth::user()->username)->with('success', 'Post Deleted');
    }

    public function deleteApi(Post $post){
      
        if (Gate::denies('delete', $post)){
            return 'you cannot delete this post';
       }
       $post->delete();

       return ('Post Deleted');
    }
    
    public function viewSinglePost(Post $post){ 
        $post['body']=strip_tags(Str::markdown($post->body),'<p><ul><li><strong><em><h3><br>');
        return view ('single-post',['post'=>$post]);
    }

    
    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        
        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::user()->id;

       $newPost = Post::create($incomingFields);


       Mail::to(Auth::user()->email)->send(new NewPostEmail(['name'=>Auth::user()->username,'title'=>$newPost->title]));

       
        return redirect("/post/{$newPost->id}")->with('success','New post created.');
        
    }


    public function storeNewPostApi(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        
        $incomingFields['title']=strip_tags($incomingFields['title']);
        $incomingFields['body']=strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = Auth::user()->id;

       $newPost = Post::create($incomingFields);


       Mail::to(Auth::user()->email)->send(new NewPostEmail(['name'=>Auth::user()->username,'title'=>$newPost->title]));

       
        return $newPost->id; 
    }

    public function showCreateForm(){
        return view('create-post');
    }

}