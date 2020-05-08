@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">View Entry</div>

                <div class="card-body">

                  <table class="table is-striped">
                    <thead>
                      <tr>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Entry Date</td>
                        <td>{{$entry->entry_date->format('l, F j, Y ') }}</td>
                      </tr>
                      <tr>
                        <td>Weight</td>
                        <td>{{ $entry->weight }} {{ auth()->user()->preference->weightUnitLabel() }}</td>
                      <tr>
                      </tr>
                        <td>Chest Circumference</td>
                        <td>{{ $entry->chestCirc }} {{ auth()->user()->preference->lengthUnitLabel() }}</td>
                      <tr>
                      </tr>
                        <td>Waist Circumference</td>
                        <td>{{ $entry->waistCirc }} {{ auth()->user()->preference->lengthUnitLabel() }}</td>
                      </tr>
                    </tbody>
                  </table>

                  <div class="buttons is-pulled-right">
                    <a href="{{ route('entries.edit', compact('entry')) }}"
                      class="button is-link">Edit</a>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
