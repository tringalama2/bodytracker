@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Entries</div>

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
                        <td>{{ $entry->getWeight(true) }}</td>
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
        </div>
    </div>
</div>
@endsection
