@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header text-white bg-primary">Your Profile</div>

                <div class="card-body">
                  @include('profile._form')

                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header text-white bg-secondary">Your Calculations</div>

                <div class="card-body">

                  @isset($latestEntry)
                      <div class="field">
                        <label class="label">Current Weight</label>
                        <div class="field has-addons">
                          <div class="control is-expanded">
                            <input type="text" value="{{ $latestEntry->getWeight() }}"
                              class="input is-info" disabled>
                          </div>
                          <div class="control">
                            <a class="button is-static">
                              {{ auth()->user()->preference->weightUnitLabel() }}
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="field">
                        <label class="label">Ideal Body Weight</label>
                        <div class="field has-addons">
                          <div class="control is-expanded">
                            <input type="text"
                              value="{{ $profile->getIBW() }}"
                              class="input is-info" disabled>
                          </div>
                          <div class="control">
                            <a class="button is-static">
                              {{ auth()->user()->preference->weightUnitLabel() }}
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="field">
                        <label class="label">Body Mass Index (BMI)</label>
                        <div class="field has-addons">
                          <div class="control is-expanded">
                            <input type="text" value="{{ $latestEntry->getBMI() }} - {{ $latestEntry->getBMIDesc() }}"
                              class="input is-info" disabled>
                          </div>
                          <div class="control">
                            <a class="button is-static">
                              kg/m&#178;
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="field">
                        <label class="label">Body Surface Area</label>
                        <div class="field has-addons">
                          <div class="control is-expanded">
                            <input type="text" value="{{ $latestEntry->getBSA() }}"
                              class="input is-info" disabled>
                          </div>
                          <div class="control">
                            <a class="button is-static">
                              m&#178;
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="field">
                        <label class="label">Basal Energy Expenditure</label>
                        <div class="field has-addons">
                          <div class="control is-expanded">
                            <input type="text" value="{{ $latestEntry->getBEE() }}"
                              class="input is-info" disabled>
                          </div>
                          <div class="control">
                            <a class="button is-static">
                              kcal/day
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="field">
                        <label class="label">Harris-Benedict Recommended Caloric Intake</label>
                        <div class="field has-addons">
                          <div class="control is-expanded">
                            <input type="text" value="{{ $latestEntry->getHarrisBenedict() }}"
                              class="input is-info" disabled>
                          </div>
                          <div class="control">
                            <a class="button is-static">
                              kcal/day
                            </a>
                          </div>
                        </div>
                      </div>
                  @endisset

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
