<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Character;
use App\User;

class CharactersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = Character::all();
        return view('characters.index')->with('characters', $characters);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $character = Character::with('users')->where('name', $slug)->firstOrFail();

        return view('characters.show')->with('character', $character);
    }

    
   public function catchAction(Request $request)
    {
        $user=auth()->user();

        if ($user->characters->count() >= 5) {
            session()->flash('error', 'en fazla 5 pokemona sahip olabilirsiniz');
            
            return redirect()->back();
        }
        
        $user->characters()->attach(
            $request->get('character_id')
        );

        return redirect('/users/'.$user->id);
        
    }

    public function battleAction(Request $request)
    {
        $characters = [];

        
        $characters[] = $request->get('my_character_id');
        $characters[] = $request->get('character_id');

        $user = User::find($request->get('user_id'));

        $pokemon = Character::whereIn('id', $characters)->get()->toArray();
        
        if ($pokemon[0]['experience'] > $pokemon[1]['experience']) {
            session()->flash('message', 'savaşı siz kazandınız');

            $user->experience -= 1;
            $user->save();
            
            auth()->user()->experience += 1;
            auth()->user()->save();
            
            return redirect()->back();
        }
        
        $user->experience += 1;
        $user->save();
        
        auth()->user()->experience -= 1;
        auth()->user()->save();

        session()->flash('message', 'savaşı kaybettiniz');
        return redirect()->back();
    }
}
