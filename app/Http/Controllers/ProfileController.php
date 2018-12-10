<?php

namespace heychum\Http\Controllers;

use Auth;
use heychum\User;
use heychum\Post;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function getProfile($id)
	{
		// $user = User::where('id', $id);
		$user = User::find($id);
		
		if (!$user){
			abort(404);
		}

		$posts = $user->posts()->get();

		return view('profile.index')->with('user', $user)
									->with('posts', $posts)
									->with('authUserIsFriend', Auth::user()->isFriendsWith($user));
	}

	public function showFriends() 
	{
        // $users = User::all()->inRandomOrder();
		$friends = Auth::user()->friends();
		
		$userposts = Post::where(function($query)	
		{
			return $query->where('user_id', Auth::user()->id);
		})
		->orderBy('created_at', 'desc')

		->paginate(30);
		$posts = Post::orderBy('created_at', 'DESC')->get();

    	return view('profile')
    		->with('friends', $friends)
    		->with('posts', $posts)
    		->with('userposts', $userposts);


        
        
	}

	public function getEdit()
	{
		return view('profile/edit');
	}
	public function postEdit(Request $request)
	{
		$this->validate($request, [
			'firstname' => 'alpha|max:50',
			'lastname' => 'alpha|max:50',
		]);

		Auth::user()->update([
			'firstname' => $request->input('firstname'),
			'lastname' => $request->input('lastname'),
		]);

		return redirect('profile/edit')->with('info', 'Your profile has been updated');
	}
}
