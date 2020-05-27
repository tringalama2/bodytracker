@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
  <div class="bg-blue-800 text-blue-100 font-bold py-2 px-4 rounded-top">All Entries</div>

        <div class="p-4 border rounded border-gray-100 static">


                  <div class="relative top-0 right-0 pb-4">
                    <a href="{{ route('entries.create') }}"
                      class="text-white bg-blue-500 hover:bg-blue-800 font-bold py-2 px-4 rounded">Add New Entry</a>
                  </div>




                <!-- tailwindcss table -->

                <table class="min-w-full align-middle shadow overflow-hidden rounded-lg border-b border-gray-200">
                  <thead>
                    <tr>
                      <th class="px-4 py-1 border-b border-blue-800 bg-blue-100 text-left align-bottom text-sm leading-4 font-medium text-blue-800 uppercase tracking-wider">Entry Date</th>
                      <th class="px-4 py-1 border-b border-blue-800 bg-blue-100 text-left align-bottom text-sm leading-4 font-medium text-blue-800 uppercase tracking-wider">Weight</th>
                      <th class="px-4 py-1 border-b border-blue-800 bg-blue-100 text-left align-bottom text-sm leading-4 font-medium text-blue-800 uppercase tracking-wider">Chest Circumference</th>
                      <th class="px-4 py-1 border-b border-blue-800 bg-blue-100 text-left align-bottom text-sm leading-4 font-medium text-blue-800 uppercase tracking-wider">Waist Circumference</th>
                    </tr>
                  </thead>
                @forelse ($entries as $entry)
                  <tbody class="bg-white">
                    <tr>
                      <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 align-middle text-base leading-5 text-gray-900">
                        <a href="{{ route('entries.show', compact('entry')) }}" class="text-indigo-600 hover:text-indigo-900">{{$entry->entry_date->format('l, F j, Y ') }}</a>
                      </td>
                      <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 align-middle">
                        <div class="text-base leading-5 text-gray-900">
                        {{ $entry->getWeight(true) }}
                        </div>
                        @isset($entry->weight_lbs)
                        <div class="text-sm leading-5 text-gray-600">
                            <span class="">BMI {{ $entry->getBMI() }}</span>
                            <span class="">kg/m&#178;</span>
                        </div>
                        @endisset
                      </td>
                      <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 align-middle text-base leading-5 text-gray-900">{{ $entry->getChestCirc(true) }}</td>
                      <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 align-middle text-base leading-5 text-gray-900">{{ $entry->getWaistCirc(true) }}</td>
                    </tr>
                  </tbody>

                @empty
                  <tbody class="bg-white">
                    <tr>
                      <td class="px-4 py-2 whitespace-no-wrap border-b border-gray-200 align-middle text-base leading-5 text-gray-900" colspan="4">No entries to display</td>
                    </tr>
                  </tbody>
                @endforelse
              </table>


        <div class="relative top-0 right-0 pt-4">
          <a href="{{ route('entries.create') }}"
            class="text-white bg-blue-500 hover:bg-blue-800 font-bold py-2 px-4 rounded">Add New Entry</a>
        </div>

        </div>


</div>
@endsection
