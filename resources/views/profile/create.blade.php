@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white bg-primary">Create Your Profile</div>

                <div class="card-body">
                  @include('profile._form')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
