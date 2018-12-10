<?php

namespace heychum\Http\Controllers;

use Auth;
use heychum\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function getIndex()
    {
    	$friends = Auth::user()->friends();
    	$requests = Auth::user()->friendRequests();

    	return view('friends.index')
    		->with('friends', $friends)
    		->with('requests', $requests);
    }

    public function getAdd($id)
    {
    	$user = User::where('id', $id)->first();

    	if (!$user) {
    		return redirect('/profile')->with('info', 'That user could not be found. Is it a ghost?');
    	}

    	if(Auth::user()->id === $user->id) {
    		return redirect('/profile')->with('info', 'Why add yourself? Why?');
    	}

    	if (Auth::user()->hasFriendRequestPending($user) || $user->
    		hasFriendRequestPending(Auth::user())) {
    		return redirect('/user/'.$id)
    		->with('info', 'Friend request already pending. Wait for it.');
    	}

    	if (Auth::user()->isFriendsWith($user)) {
    		return redirect('/user/'.$id)
    		->with('info', 'You are already friends. Want something more?');
    	}

    	Auth::user()->addFriend($user);

    		return redirect('/user/'.$id)
    		->with('info', 'Friend request sent. You do know that person right?');
    }

    public function getAccept($id)
    {

    	// dd($id);
    	$user = User::where('id', $id)->first();

    	if (!$user) {
    		return redirect('/profile')->with('info', 'That user could not be found');
    	}

    	if (!Auth::user()->hasFriendRequestReceived($user)) {
    		return redirect('/profile');
    		# code...
    	}

    	Auth::user()->acceptFriendRequest($user);

    	return redirect('/user/'.$id)->with('info', 'Friend request accepted. ');

    }
}
