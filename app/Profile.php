<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Preference;

class Profile extends Model
{

  const MALE='m';
  const FEMALE='f';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'gender', 'birth_date', 'height_in', 'start_weight_lbs',
  ];

  protected $casts = [
      'height_in' => 'decimal:2',
      'start_weight_lbs' => 'decimal:1',
  ];

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
      'birth_date',
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

  public function calculateIBWkg(string $gender, float $height_in)
  {
    // Ideal Body Weight (Devine formula):
    // • Ideal body weight (IBW) (men) = 50 kg + 2.3 kg x (height, in - 60)
    // • Ideal body weight (IBW) (women) = 45.5 kg + 2.3 kg x  (height, in - 60)
    // • Note: this formula is only an approximation, and is generally only applicable for people 60 inches (5 foot) tall or greater. For patients under 5 feet, one commonly-used modification is to subtract 2-5 lbs for each inch below 60 inches (written communication with leading expert Dr. Manjunath Pai, 2018).
    $genderBasedAddKg = strtolower(substr($gender, 0, 1)) == 'm' ? 50 : 45.5;

    return (2.3 * ($height_in - 60)) + $genderBasedAddKg;
  }

  public function calculateIBWlbs(string $gender, float $height_in)
  {
    return Preference::kilogramsToPounds($this->calculateIBWkg($gender, $height_in));
  }

  public function getIBW()
  {
    if (auth()->user()->preference->prefersImperial()) {
      return round($this->calculateIBWlbs(
        $this->gender,
        $this->height_in
      ), 0);
    } else {
      return round($this->calculateIBWkg(
        $this->gender,
        $this->height_in
      ), 0);
    }
  }

  public function calculateABW()
  {
    // Adjusted Body Weight (ABW), for use in obese patients (where actual body weight > IBW):
    // • ABW = IBW + 0.4 x (actual body weight - IBW)

  }
}
