<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Preference;

class Profile extends Model
{

  const MALE='m';
  const FEMALE='f';

  function __construct() {

      //ddd(auth()->user()->preference);
  }
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'gender', 'height_in', 'start_weight_lbs',
  ];

  protected $casts = [
      'height_in' => 'decimal:2',
      'start_weight_lbs' => 'decimal:1',
  ];

  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function getStartWeightAttribute()
  {
    if (auth()->user()->preference->prefersImperial()) {
    // if ($this->user()->preference()->prefersImperial()) {
      return $this->start_weight_lbs;
    } else {
      return Preference::poundsToKilograms($this->start_weight_lbs);
    }
  }

  public function getHeightAttribute()
  {
    if (auth()->user()->preference->prefersImperial()) {
    //if ($this->user()->preference()->prefersImperial()) {
      return $this->height_in;
    } else {
      return Preference::inchesToCentimeters($this->height_in);
    }
  }

  public function setHeightInAttribute($value)
  {
    $this->attributes['height_in'] = auth()->user()->preference->prefersImperial() ? $value : Preference::centimetersToInches($value);
  }

  public function setStartWeightLbsAttribute($value)
  {
    $this->attributes['start_weight_lbs'] = auth()->user()->preference->prefersImperial() ? $value : Preference::kilogramsToPounds($value);
  }

  public function isMale()
  {
    return $this->gender==self::MALE;
  }

  public function isFemale()
  {
    return $this->gender==self::FEMALE;
  }

}
