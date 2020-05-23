<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Entry;
use Carbon\Carbon;

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
    public function index(Request $request)
    {
      $date = null;

      // restrict to date interval if passed in route
      if(isset($request->unit)) {
        $date = Carbon::now();
        $interval = intval($request->interval ?? 1);

        switch ($request->unit) {
          case 'year':
          case 'y':
          case 'yr':
          case 'years':
            $date->subYears($interval);
            break;
          case 'month':
          case 'm':
          case 'mon':
          case 'months':
            $date->subMonths($interval);
            break;
          case 'week':
          case 'w':
          case 'wk':
          case 'weeks':
            $date->subWeeks($interval);
            break;
          case 'day':
          case 'd':
          case 'days':
            $date->subDays($interval);
            break;
          case 'ytd':
            $date->startOfYear();
        }
      }


      $entries = Entry::where('user_id', Auth::id())
            ->when($date, function ($query, $date) {
                return $query->whereDate('entry_date', '>=', $date);
            })
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
