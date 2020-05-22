<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entry;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $entries = Entry::where('user_id', Auth::id())
            ->orderBy('entry_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

      return view ('home', [
        'entries' => $entries,
        'jsonEntryDates' => json_encode($entries->pluck('entry_date')
              ->transform(function ($item, $key) {
                  return $item->format('F j, Y ');
             })->toArray()),
        'jsonWeightLbs' => json_encode($entries->pluck('weight')
              ->transform(function ($item, $key) {
                  return (float)$item;
                })->toArray())
      ]);
    }
}
