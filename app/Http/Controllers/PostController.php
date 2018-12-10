<?php

namespace heychum\Http\Controllers;

use Auth;
use Image;
use heychum\User;
use heychum\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();
        // return view('post.index')->withPosts($posts)
        // ;


        if (Auth::check()) {
         $posts = Post::where(function($query)

         {
            return $query->where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));

        })
         ->orderBy('created_at', 'desc')

         ->paginate(30);


         return view('post.index')->with('posts', $posts)
         ;
     }

     return view('/home');
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'title' => 'required|max:255',
            'body' => 'nullable|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $post = new Post;
             if($request->hasFile('image')!=null){ //if i uploaded another image
                 $image = $request->file('image');
                 $image_name = time() . "." .$image->getClientOriginalExtension();
                 $destination = ("images/" . $image_name);
                 Image::make($image)->resize(800, 600)->save($destination);
                 $post->image = $image;
             }else{
                $image_name ="";
            }

            Auth::user()->posts()->create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'image' => $image_name,
            ]);



            return redirect('/post')->with('info', 'Status posted');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $post = Post::find($id);

       return view('post.show', compact('post'));
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {

        $post = Post::find($id);
        //validations
        $rules = array(
            "title" => "required",
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        );
        $this->validate($request, $rules);
        $post->title = $request->title; //$request->name, name comes from the name in the input type
        $post->body = $request->body;
        if($request->file('image')!=null){ //if i uploaded another image
            $image = $request->file('image');
            $image_name = time() . "." .$image->getClientOriginalExtension();
            $destination = "images/";
            $image->move($destination, $image_name);
            $post->image = $image_name;
        }

        $post->save();
        return redirect("/post/show/".$id)->with('info', 'Your post has been updated');
    }

    public function share($id , Request $request)
    {

        Auth::user()->posts()->create([
            'title' => $request->input('post_title'),
            'body' => $request->input('post_body'),
            'shared_title' => $request->input('shared_title'),
            'shared_name' => $request->input('shared_name'),
            'shared_image' => $request->input('shared_image'),
            'shared_body' => $request->input('shared_body'),
            'shared_id' => $id,
        ]);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $post = Post::find($id);
         $post->delete();
         return redirect('/post')->with('info', 'Your post has been deleted');
    }

    public function getLike($id)
    {

        if(!$post = Post::findOrFail($id))
        {
            return redirect('/post');
        }

        if(!Auth::user()->isFriendsWith($post->user))
        {
            return redirect('/post');
        }

        if(Auth::user()->hasLikedPost($post))
        {
            return redirect()->back();
        }

        $like = $post->likes()->create([
            'user_id' => Auth::user()->id,
        ]);
        Auth::user()->likes()->save($like);

        return redirect()->back();
    }
}
