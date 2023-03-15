@extends('layouts.main')

@section('title', 'Edit ' . $project->name)
    
@section('content')

<div class="container py-5 text-center">
    <h1 class="mb-5">EDIT PROJECT</h1>
    @include('includes.alerts.errors')
    @include('includes.projects.form')
</div>
@endsection