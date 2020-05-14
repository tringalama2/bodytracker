<?php

namespace App\Http\Controllers;

use App\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
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
      return view ('preference.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validAttributes = $this->validatePreference();

      $validAttributes['user_id'] = Auth::id();

      $preference = Preference::create($validAttributes);

      $request->session()->flash('info', 'Great!  Now let\'s wrap up with a little more about you.');

      return redirect(route('profile.create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function edit(Preference $preference)
    {
      if (auth()->user()->preference === null)
      {
          return redirect(route('preference.create'));
      }

      return view ('preference.edit', [
        'preference' => auth()->user()->preference,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preference  $preference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preference $preference)
    {
      auth()->user()->preference->update($this->validatePreference());

      $request->session()->flash('success', 'Preferences have been saved.');

      return redirect(route('preference.edit'));
    }

    protected function validatePreference()
    {
      return request()->validate([
        'unit_dipslay_preference_id' => 'required|in:1,2',
      ]);
    }

}
