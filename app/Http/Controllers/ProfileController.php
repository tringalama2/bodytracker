<?php

namespace App\Http\Controllers;

use App\Profile;
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

      return redirect(route('profile.edit'));
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

      return view ('profile.edit', [
        'profile' => auth()->user()->profile,
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

      return redirect(route('profile.edit'));
    }

    protected function validateProfile()
    {
      return request()->validate([
        'gender' => 'required|in:m,f',
        'height_in' => 'numeric',
        'start_weight_lbs' => 'numeric',
      ]);
    }

}
