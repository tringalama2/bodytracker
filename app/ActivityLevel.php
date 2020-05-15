<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLevel extends Model
{

  public function profiles()
  {
      return $this->hasMany('App\Profile');
  }

  public function getLabelAndDescAttribute()
  {
    return $this->label . ' (' . $this->desc . ')';
  }
}
