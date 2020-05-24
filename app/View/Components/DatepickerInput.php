<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatepickerInput extends Component
{
    public $name;
    public $value;
    public $model;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $value,
        $model
      )
    {
      $this->name = $name;
      $this->value = $value;
      $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.datepicker-input');
    }
}



// Example

//<x-datepicker-input name="birth_date" value="1978-05-04" :model="auth()->user()->profile"/>
