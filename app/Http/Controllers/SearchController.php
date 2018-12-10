<?php

namespace heychum\Http\Controllers;
use DB;
use heychum\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getResults(Request $request) {

    	$query = $request->input('query');

    	if (!$query) {
    		return redirect("/home");
    	}

    	$users = User::where('firstname', 'LIKE', "%{$query}%")
    		->orWhere('lastname', 'LIKE', "%{$query}%")
    		->orWhere('username', 'LIKE', "%{$query}%")
    		->get();

    	return view('search.results')->with('users', $users);
    }

}
