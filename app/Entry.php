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

  public function calculateBMI($weight_lbs, $height_in)
  {
    // Body mass index, kg/m2 = weight, kg / (height, m)2
  	return Preference::poundsToKilograms($weight_lbs) / (Preference::inchesToCentimeters($height_in)/100) ** 2;
  }

  public function getBMI()
  {
    return round($this->calculateBMI(
      $this->weight_lbs,
      auth()->user()->profile->height_in
    ), 1);
  }
  public function getBMIDesc()
  {
    return $this->BMItoDesc($this->getBMI());
  }

  public function BMItoDesc(float $bmi)
  {
  	if ($bmi < 18.5) {
  		return 'Below normal weight';
  	} elseif ($bmi < 25) {
  		return 'Normal weight';
  	} elseif ($bmi < 30) {
  		return 'Overweight';
  	} elseif ($bmi < 35) {
  		return 'Class 1 Obesity';
  	} elseif ($bmi < 40) {
  		return 'Class 2 Obesity';
  	} else {
  		return 'Class 3 Obesity';
  	}
  }

  public function getBSA()
  {
    return round($this->calculateBSA(
      auth()->user()->profile->height_in,
      $this->weight_lbs
    ), 2);
  }


  public function calculateBSA($height_in, $weight_lbs)
  {
    // Body surface area (the Mosteller formula), m2 = [ Height, cm x Weight, kg  / 3600 ]^1/2
    return (Preference::inchesToCentimeters($height_in) * Preference::poundsToKilograms($weight_lbs) / 3600) ** 0.5;
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
