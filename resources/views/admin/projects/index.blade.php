@extends('layouts.main')

@section('title', 'PROJECTS')
    
@section('content')

<div class="container py-5 text-center">
    <h1>PROJECTS</h1>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Project Name</th>
            <th scope="col">Type</th>
            <th scope="col">Technologies</th>
            <th scope="col" class="d-flex flex-column align-items-center justify-content-center">
                Publication Status
                <form id="filter-form" action="{{ route('admin.projects.index') }}" method="GET">
                    <select class="mt-1 form-control-sm text-center" name="status-filter" id="status-filter">
                        <option value="" @if($selected === 'all') selected @endif >All</option>
                        <option value="drafted" @if($selected === 'drafted') selected @endif >Drafted</option>
                        <option value="published" @if($selected === 'published') selected @endif >Published</option>
                    </select>
                </form>
            </th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
            <tr>
                <th class="align-middle" scope="row">{{ $project->id }}</th>
                <td class="align-middle">{{ $project->name }}</td>
                <td class="align-middle"><span class="@if($project->type)badge rounded-pill p-2 @endif" style="background-color: {{ $project->type?->color }}">{{ $project->type ? $project->type->label : '-' }}</span></td>
                <td class="align-middle" style="max-width: 150px">
                    <div class="row row-cols-3 text-center justify-content-center align-items-center">
                    @forelse ($project->technologies as $technology)
                        <div class="col" style="color: {{ $technology->color }}"><h2 class="mb-0">{!! $technology->icon !!}</h2></div>
                    @empty
                        -
                    @endforelse
                    </div>
                </td>
                <td class="align-middle">
                    <form class="mb-0 text-center" action="{{ route('admin.projects.toggle-status', $project->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <button class="btn">
                            <i class="fa-solid fa-2x fa-toggle-{{$project->is_published ? 'on text-success' : 'off text-danger'}}"></i>
                        </button>
                    </form>
                </td>
                <td class="align-middle">{{ $project->created_at }}</td>
                <td class="align-middle">{{ $project->updated_at }}</td>
                <td class="align-middle"> 
                    <a class="btn btn-small btn-primary" href="{{ route('admin.projects.show', $project->id) }}"><i class="fa-solid fa-eye"></i></a> 
                    <a class="btn btn-small btn-warning" href="{{ route('admin.projects.edit', $project->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                    <form class="d-inline delete-form" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" data-project-name="{{ $project->name }}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-small btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </form>
                </td>
            </tr> 
            @empty
            <tr>
                <th scope="row" colspan="8" class="text-center">Non ci sono progetti</th>
            </tr> 
            @endforelse
          
        </tbody>
    </table>

    <div class="buttons d-flex justify-content-end mb-5">
        <a href="{{ route('admin.projects.trash.index') }}" class="btn btn-small btn-secondary me-2"><i class="fa-solid fa-trash-can"></i></a>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-small btn-success"><i class="fa-solid fa-plus"></i></a>
    </div>

    <div class="offset-9 col-3" >{{ $projects->links() }}</div>

    @include('includes.projects.delete-modal')

</div>
    
@endsection

@section('scripts')
    <script>
        const filterForm = document.getElementById('filter-form');
        const statusFilter = document.getElementById('status-filter');
        statusFilter.addEventListener('change', () => {
            filterForm.submit();
        })
    </script>
@endsection
