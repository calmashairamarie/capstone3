<?php

namespace heychum\Http\Controllers\Adminpanel;

use Illuminate\Http\Request;
use heychum\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function index() {
        return 'This is the admin dashboard';
    }
}
