<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Models\Reservation;

class HomeController extends Controller
{

  //Constract...........................................
    public function __construct()
    {
        $this->middleware('auth');
       
    }

    public function index()
    {
        try {
            $users = User::count();
            return view('counters', compact('users'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to Upload home page');
        }
    }
}
    

