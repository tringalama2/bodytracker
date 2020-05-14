<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Entry;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('profile')->except('create', 'store');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view ('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validAttributes = $this->validateProfile();

      $validAttributes['user_id'] = Auth::id();

      $profile = Profile::create($validAttributes);


      // save starting weight to an entry
      Entry::create([
        'user_id' => Auth::id(),
        'entry_date' => now(),
        'weight_lbs' => $validAttributes['start_weight_lbs'],
        ]);

      $request->session()->flash('info', 'That\'s it!  You are ready to start logging entries.');

      return redirect(route('entries.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      if (auth()->user()->profile === null)
      {
          return redirect(route('profile.create'));
      }

      $latestEntry = auth()->user()->latestEntry;

      return view ('profile.edit', [
        'profile' => auth()->user()->profile,
        'latestEntry' => $latestEntry,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      auth()->user()->profile->update($this->validateProfile());

      $request->session()->flash('success', 'Profile has been saved.');

      return redirect(route('profile.edit'));
    }

    protected function validateProfile()
    {
      return request()->validate([
        'gender' => 'required|in:m,f',
        'birth_date' => 'required|date',
        'height_in' => 'numeric',
        'start_weight_lbs' => 'numeric',
      ]);
    }

}
