<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class EntryController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view ('entries.index', [
        'entries' => Entry::where('user_id', Auth::id())
              ->orderBy('entry_date', 'desc')
              ->orderBy('created_at', 'desc')
              ->get(),
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view ('entries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validAttributes = $this->validateEntry();

      $validAttributes['user_id'] = Auth::id();

      Entry::create($validAttributes);

      $request->session()->flash('success', 'Entry has been saved.');

      return redirect(route('entries.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
      return view ('entries.show', [
        'entry' => $entry,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
      return view ('entries.edit', [
        'entry' => $entry
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
      //check that user is owner of record
      // TBD

      $entry->update($this->validateEntry());

      $request->session()->flash('success', 'Entry has been updated.');

      return redirect(route('entries.show', compact('entry')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
      //check that user is owner of record
      // TBD



      $entry->delete();

      Session::flash('success', 'Entry was deleted.');

      return redirect(route('entries.index'));
    }

    protected function validateEntry()
    {
      return request()->validate([
          'entry_date' => 'required|date',
          'weight_lbs' => 'nullable|numeric',
          'chest_circ_in' => 'nullable|numeric',
          'waist_circ_in' => 'nullable|numeric',
      ]);
    }
}
