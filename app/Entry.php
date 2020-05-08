<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Preference;

class Entry extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'entry_date', 'weight_lbs', 'chest_circ_in', 'waist_circ_in',
  ];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
      'entry_date',
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function getWeightAttribute()
  {
    if (auth()->user()->preference->prefersImperial()) {
      return $this->weight_lbs;
    } else {
      return Preference::poundsToKilograms($this->weight_lbs);
    }
  }

  public function getChestCircAttribute()
  {
    if (auth()->user()->preference->prefersImperial()) {
      return $this->chest_circ_in;
    } else {
      return Preference::inchesToCentimeters($this->chest_circ_in);
    }
  }

  public function getWaistCircAttribute()
  {
    if (auth()->user()->preference->prefersImperial()) {
      return $this->waist_circ_in;
    } else {
      return Preference::inchesToCentimeters($this->waist_circ_in);
    }
  }

  public function setWeightLbsAttribute($value)
  {
    $this->attributes['weight_lbs'] = auth()->user()->preference->prefersImperial() ? $value : Preference::kilogramsToPounds($value);
  }

  public function setChestCircInAttribute($value)
  {
    $this->attributes['chest_circ_in'] = auth()->user()->preference->prefersImperial() ? $value : Preference::centimetersToInches($value);
  }

  public function setWaistCircInAttribute($value)
  {
    $this->attributes['waist_circ_in'] = auth()->user()->preference->prefersImperial() ? $value : Preference::centimetersToInches($value);
  }

  public function userPrefersImperial()
  {
    return auth()->user()->profile->unit_dipslay_preference_id==Preference::IMPERIAL_SYSTEM_ID;
  }

}
