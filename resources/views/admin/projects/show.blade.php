@extends('layouts.main')

@section('title', $project->name)
    
@section('content')

<div class="container py-5 text-center">
    <h1 class="mb-5">PROJECT OVERVIEW</h1>
    <div class="card bg-dark text-light p-5 mb-5">
        <div class="project-title d-flex align-items-center justify-content-center mb-1">
            <h3>{{ ucfirst($project->name) }}</h3>
            @if($project->type) <span class="badge rounded-pill p-2 ms-3" style="background-color: {{ $project->type->color }}">{{ $project->type->label }}</span>@endif
        </div>
        <div class="technologies d-flex m-auto mb-5">
            @forelse ($project->technologies as $technology)
                    <div class="text-center me-3" style="color: {{ $technology->color }}"><h4 class="mb-0">{!! $technology->icon !!}</h4></div>
            @empty

            @endforelse
        </div>
        <div class="card-top clearfix text-start mb-5">
            <img class="float-start d-block me-3 img-fluid" src="{{ $project->getImageUrl() }}" alt="{{ $project->name }}">
            <p>{{ $project->description }}</p>
        </div>
        <hr>
        <div class="card-bottom text-start">
            <p><i class="fa-brands fa-github"></i> <a href="{{ $project->project_url }}">{{ ucfirst($project->name) }}</a></p>
        </div>
    </div>
    <div class="buttons d-flex align-items-center justify-content-end">
        <form class="d-flex align-items-center" action="{{ route('admin.projects.toggle-status', $project->id) }}" method="POST">
            @method('PATCH')
            @csrf
            <p class="mb-1">Published Status:</p>
            <button class="btn">
                <i class="fa-solid fa-3x fa-toggle-{{$project->is_published ? 'on text-success' : 'off text-danger'}}"></i>
            </button>
        </form>
        <a class="btn btn-small btn-warning me-2" href="{{ route('admin.projects.edit', $project->id) }}">Edit</a>
        <form class="delete-form" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" data-project-name="{{ $project->name }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-small btn-danger me-2">Delete</button>
        </form>
        <a class="btn btn-small btn-primary me-2" @if($project->deleted_at) href="{{ route('admin.projects.trash.index') }}" @else href="{{ route('admin.projects.index') }}" @endif>Back</a>
    </div>
</div>

@include('includes.projects.delete-modal')

@endsection

