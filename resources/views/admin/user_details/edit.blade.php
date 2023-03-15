@extends('layouts.main')

@section('title', 'USER DETAILS')

@section('content')

<div class="container py-5 text-center">
    <h1>EDIT USER DETAILS</h1>
    @include('includes.alerts.errors')
    @include('includes.user_details.form')
    </div>
</div>
    
@endsection