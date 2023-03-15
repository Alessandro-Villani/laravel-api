@extends('layouts.main')

@section('title', 'DASHBOARD')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body text-center">
                    @if(Auth::user()->userDetail)
                        <div class="row mb-3">
                            <div class="col-3">
                                <img class="img-fluid" src="{{ Auth::user()->userDetail->profile_pic ? asset('storage/' . Auth::user()->userDetail->profile_pic)  : 'https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png' }}" alt="{{Auth::user()->name}}"></div>
                                
                            <div class="col-9 row align-items-center text-start">
                                <div class="col-6">
                                    <h4>Name: {{ Auth::user()->userDetail->first_name }}</h4>
                                </div>
                                <div class="col-6">
                                    <h4>Surname: {{ Auth::user()->userDetail->last_name }}</h4>
                                </div>
                                <div class="col-12">
                                    <h6>Address: {{ Auth::user()->userDetail->address }}</h6>
                                </div>                                
                            </div>
                        </div>

                        <a class="btn btn-primary" href="{{ route('admin.user_details.edit', Auth::id()) }}">Edit Profile Data</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('admin.user_details.create') }}">Add Profile Data</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
