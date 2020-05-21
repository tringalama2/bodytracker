@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white bg-primary">All Entries</div>

                <div class="card-body">
                  <div class="buttons is-pulled-right">
                    <a href="{{ route('entries.create') }}"
                      class="button is-link">Add New Entry</a>
                  </div>

                  <table class="table is-striped">
                    <thead>
                      <tr>
                        <th>Entry Date</th>
                        <th>Weight</th>
                        <th>Chest Circumference</th>
                        <th>Waist Circumference</th>
                      </tr>
                    </thead>
                  @forelse ($entries as $entry)
                    <tbody>
                      <tr>
                        <td><a href="{{ route('entries.show', compact('entry')) }}">{{$entry->entry_date->format('l, F j, Y ') }}</a></td>
                        <td>
                          <div>
                          {{ $entry->getWeight(true) }}
                          </div>
                          @isset($entry->weight_lbs)
                          <div>
                              <span class="is-size-7">BMI {{ $entry->getBMI() }}</span>
                              <span class="is-size-7">kg/m&#178;</span>
                          </div>
                          @endisset
                        </td>
                        <td>{{ $entry->getChestCirc(true) }}</td>
                        <td>{{ $entry->getWaistCirc(true) }}</td>
                      </tr>
                    </tbody>

                  @empty
                    <tbody>
                      <tr>
                        <td colspan="4">No entries to display</td>
                      </tr>
                    </tbody>
                  @endforelse
                </table>

                  <div class="buttons is-pulled-right">
                    <a href="{{ route('entries.create') }}"
                      class="button is-link">Add New Entry</a>
                  </div>

                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header text-white bg-secondary">Weight Trend</div>

                <div class="card-body">
                  <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>


    </div>
</div>


@endsection

@section('scripts')
  @parent
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script>
    window.onload = function() {
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: {!! $jsonEntryDates !!},
            datasets: [{
                label: 'Weight ({{ auth()->user()->preference->weightUnitLabel() }})',
                borderColor: 'rgb(40, 167, 69)',
                backgroundColor: 'rgba(40, 167, 69, 0.3)',
                data: {!! $jsonWeightLbs !!},
                fill: true,
            }]
        },

        // Configuration options go here
        options: {
          responsive: true,
          tooltips: {
            position: 'nearest',
            mode: 'index',
            intersect: false,
          },
        }
      });
    };
  </script>
@endsection
