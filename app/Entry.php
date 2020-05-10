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

  public function getWeight($withUnits = false)
  {
    return $this->getMeasurement($this->weight_lbs, 'weight', $withUnits);
  }

  public function getChestCirc($withUnits = false)
  {
    return $this->getMeasurement($this->chest_circ_in, 'length', $withUnits);
  }

  public function getWaistCirc($withUnits = false)
  {
    return $this->getMeasurement($this->waist_circ_in, 'length', $withUnits);
  }

  public function getMeasurement($measurement, $type = 'length', $withUnits = false)
  {
    $label = $type == 'length' ?
      auth()->user()->preference->lengthUnitLabel() :
      auth()->user()->preference->weightUnitLabel();

    $measurement = auth()->user()->preference->prefersImperial() ?
      $measurement :
      (
        $type == 'length' ?
        Preference::inchesToCentimeters($measurement) :
        Preference::poundsToKilograms($measurement)
      );

    if (!$withUnits) {
      return $measurement;
    } else {
      return $measurement == null ? null : $measurement.' '.$label;
    }
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

  //
  //
  // public function convertWithDisplayUnits($attr, $type)
  // {
  //   if ($this->attributes[$attr] == null) {
  //     return null;
  //   } else {
  //     if ($type = 'length' || $type = 'len') {
  //       return (
  //         auth()->user()->preference->prefersImperial() ?
  //           $this->attributes[$attr] :
  //           Preference::inchesToCentimeters($this->attributes[$attr])
  //         )
  //         . ' ' . auth()->user()->preference->lengthUnitLabel();
  //     } else {
  //       return (
  //         auth()->user()->preference->prefersImperial() ?
  //           $this->attributes[$attr] :
  //           Preference::poundsToKilograms($this->attributes[$attr])
  //         )
  //         . ' ' . auth()->user()->preference->weightUnitLabel();
  //     }
  //   }
  //
  // }
}
