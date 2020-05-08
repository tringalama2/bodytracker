<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckProfileCreated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if ($request->user()->hasPreference() == false) {
        $request->session()->flash('info', 'Before we get started, I need a little information about your preferences.');
        return Redirect::route('preference.create');
        //return redirect(route('preference.create'));
      } elseif ($request->user()->hasProfile() == false) {
        //return redirect(route('profile.create'));
        return Redirect::route('profile.create');
      }

      return $next($request);
    }
}
