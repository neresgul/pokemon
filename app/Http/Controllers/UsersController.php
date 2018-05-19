<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index(){

    	$users = User::all();
    	return view('users.index')->with('users', $users);
    }

    public function show($id){

    	$user= User::with('characters')->find($id);
    	return view('users.show')->with('user',$user);
    }
}
