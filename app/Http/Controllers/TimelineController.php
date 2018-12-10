<?php

namespace heychum\Http\Controllers;

use Auth;
// use heychum\User;
use heychum\Status;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function newsfeed()
    {
        if (Auth::check()) {
        	$statuses = Status::where(function($query)
        	{
        		return $query->where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends());
        		// return $query->where('user_id', Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends()->lists('id'));
        	})
			->orderBy('created_at', 'desc')
			// ->get();
			->paginate(30);

			// dd($statuses);

            return view('timeline.index')->with('statuses', $statuses);
        }

        return view('/home');
    }
}
