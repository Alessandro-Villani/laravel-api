@extends('layouts.main')

@section('title', 'Add Project')
    
@section('content')

<div class="container py-5 text-center">
    <h1 class="mb-5">ADD PROJECT</h1>
    @include('includes.alerts.errors')
    @include('includes.projects.form')
</div>

@endsection