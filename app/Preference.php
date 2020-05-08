<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
  /* values for unit_dipslay_preference_id */
  const IMPERIAL_SYSTEM_ID=1;
  const METRIC_SYSTEM_ID=2;
  const IMPERIAL_SYSTEM_NAME="imperial";
  const METRIC_SYSTEM_NAME="metric";
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'unit_dipslay_preference_id',
  ];

  protected $casts = [
      'unit_dipslay_preference_id' => 'integer',
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function lengthUnitLabel()
  {
    return $this->prefersImperial() ? 'in' : 'cm';
  }

  public function weightUnitLabel()
  {
    return $this->prefersImperial() ? 'lb' : 'kg';
  }

  public function prefersMetric()
  {
    return (int)$this->unit_dipslay_preference_id==self::METRIC_SYSTEM_ID;
  }

  public function prefersImperial()
  {
    return (int)$this->unit_dipslay_preference_id==self::IMPERIAL_SYSTEM_ID;
  }

  public function setDisplayUnitsToImperial()
  {
    $this->unit_dipslay_preference_id = self::IMPERIAL_SYSTEM_ID;
    $this->save();
  }

  public function setDisplayUnitsToMetric()
  {
    $this->unit_dipslay_preference_id = self::METRIC_SYSTEM_ID;
    $this->save();
  }

  public function getPrefersImperialUnitsAttribute()
  {
    return $this->prefersImperial();
  }

  public function getPrefersMetriclUnitsAttribute()
  {
    return $this->prefersMetric();
  }


  public static function inchesToCentimeters($distanceInInches)
  {
    return round($distanceInInches * 2.54, 2);
  }

  public static function centimetersToInches($distanceInCentimeters)
  {
    return round($distanceInCentimeters * 0.393700787, 2);
  }

  public static function poundsToKilograms($weightInPounds)
  {
    return round($weightInPounds * 0.45359237, 1);
  }

  public static function kilogramsToPounds($weightInKilograms)
  {
    return round($weightInKilograms * 2.20462262, 1);
  }



  /*

    public static function units($system_id)
    {
      return collect([
        [
          'system_name' => 'metric',
          'system_id' => 2,
          'measure' => 'distance-sm',
          'unit' => 'centimeter',
          'abbr' => 'cm',
          'convertToImperial' => 0.393700787,
        ],
        [
          'system_name' => 'metric',
          'system_id' => 2,
          'measure' => 'distance-md',
          'unit' => 'meter',
          'abbr' => 'm',
          'convertToImperial' => 3.2808399,
        ],
        [
          'system_name' => 'metric',
          'system_id' => 2,
          'measure' => 'distance-lg',
          'unit' => 'kilometer',
          'abbr' => 'km',
          'convertToImperial' => 0.621371192,
        ],
        [
          'system_name' => 'metric',
          'system_id' => 2,
          'measure' => 'weight-sm',
          'unit' => 'gram',
          'abbr' => 'g',
          'convertToImperial' => 0.0352733686,
        ],
        [
          'system_name' => 'metric',
          'system_id' => 2,
          'measure' => 'weight-md',
          'unit' => 'kilogram',
          'abbr' => 'kg',
          'convertToImperial' => 2.20462262,
        ],
        [
          'system_name' => 'metric',
          'system_id' => 2,
          'measure' => 'weight-lg',
          'unit' => 'metric ton',
          'abbr' => 't',
          'convertToImperial' => 0.984206528,
        ],
        [
          'system_name' => 'imperial',
          'system_id' => 1,
          'measure' => 'distance-sm',
          'unit' => 'inch',
          'abbr' => 'in',
          'convertToMetric' => 2.54,
        ],
        [
          'system_name' => 'imperial',
          'system_id' => 1,
          'measure' => 'distance-md',
          'unit' => 'foot',
          'abbr' => 'ft',
          'convertToMetric' => 0.3048,
        ],
        [
          'system_name' => 'imperial',
          'system_id' => 1,
          'measure' => 'distance-lg',
          'unit' => 'mile',
          'abbr' => 'mi',
          'convertToMetric' => 1.609344,
        ],
        [
          'system_name' => 'imperial',
          'system_id' => 1,
          'measure' => 'weight-sm',
          'unit' => 'ounce',
          'abbr' => 'oz',
          'convertToMetric' => 28.35,
        ],
        [
          'system_name' => 'imperial',
          'system_id' => 1,
          'measure' => 'weight-md',
          'unit' => 'pound',
          'abbr' => 'lb',
          'convertToMetric' => 0.45359237,
        ],
        [
          'system_name' => 'imperial',
          'system_id' => 1,
          'measure' => 'weight-lg',
          'unit' => 'UK long ton',
          'abbr' => 'ton',
          'convertToMetric' => 1.01604691,
        ],
      ])->where('system_id', $system_id);
    }
    */
}
