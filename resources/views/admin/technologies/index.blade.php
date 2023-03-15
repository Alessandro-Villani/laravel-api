@extends('layouts.main')

@section('title', 'TECHNOLOGIES')
    
@section('content')

<div class="container py-5 text-center">
    <h1>Technologies</h1>
    @include('includes.alerts.errors')
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Technology Name</th>
            <th scope="col">Technology Icon</th>
            <th scope="col">Color</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="technologies-table">
            @forelse ($technologies as $technology)
            <tr id="technology-{{$technology->id}}-row">
                <th class="align-middle" scope="row">{{ $technology->id }}</th>
                <td class="name align-middle">{{ $technology->name }}</td>
                <td class="name-edit align-middle d-none"><input type="text" value="{{ $technology->name }}"></td>
                <td class="icon align-middle" style="color: {{ $technology->color }}"><h2 class="mb-0">{!! $technology->icon !!}</h2></td>
                <td class="icon-edit align-middle d-none"><input type="text" value="{{ $technology->icon }}"></td>
                <td class="align-middle"><input class="color" type="color" value="{{ $technology->color }}" disabled></td>
                <td class="align-middle">{{ $technology->created_at }}</td>
                <td class="align-middle">{{ $technology->updated_at }}</td>
                <td class="align-middle">
                    <button class="btn btn-edit btn-warning" data-id="{{ $technology->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                    <form class="d-none edit-form" action="{{ route('admin.technologies.update', $technology->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input class="edited-name" type="hidden" name="name">
                        <input class="edited-icon" type="hidden" name="icon">
                        <input class="edited-color" type="hidden" name="color">
                        <button class="btn btn-edit btn-success" ><i class="fa-solid fa-check"></i></button>
                    </form>
                    <button class="btn btn-close-edit btn-secondary d-none"><i class="fa-solid fa-xmark"></i></button>
                    <form class="d-inline delete-form" action="{{ route('admin.technologies.destroy', $technology->id) }}" method="POST" data-project-name="{{ $technology->name }}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-small btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <th scope="row" colspan="7" class="text-center">Non ci sono tecnologie</th>
            </tr> 
            @endforelse  
            <tr id="add-technology-row" class="d-none">   
                <th class="align-middle" scope="row"></th>
                <td class="align-middle"><input id="name-holder" type="text"></td>
                <td class="align-middle"><input id="icon-holder" type="text"></td>
                <td class="align-middle"><input id="color-holder" type="color"></td>
                <td class="align-middle"></td>
                <td class="align-middle"></td>
                <td class="align-middle d-flex justify-content-center align-items-center"> 
                    <form id="submit-add-form" action="{{route('admin.technologies.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="name" id="name">
                        <input type="hidden" name="icon" id="icon">
                        <input type="hidden" name="color" id="color">
                        <button class="btn btn-small btn-success me-2"><i class="fa-solid fa-check"></i></button>
                    </form>
                    <button id="close-add-row" class="btn btn-small btn-danger"><i class="fa-solid fa-xmark"></i></button>
                </td>
            </tr>       
        </tbody>
    </table>

    <div class="buttons d-flex justify-content-end mb-5">
        <button id="add-technology" class="btn btn-small btn-success"><i class="fa-solid fa-plus"></i></button>
    </div>

    <div class="offset-9 col-3" >{{ $technologies->links() }}</div>

    @include('includes.projects.delete-modal')

</div>
    
@endsection

@section('scripts')
    <script>
        //ADD TYPE SCRIPT

        const addTechnologyRow = document.getElementById('add-technology-row')
        const addButton = document.getElementById('add-technology');
        const submitAddForm = document.getElementById('submit-add-form');
        const closeAddRow = document.getElementById('close-add-row');

        addButton.addEventListener('click', () => {
            addTechnologyRow.classList.remove('d-none');
            addButton.disabled = true;
        });

        submitAddForm.addEventListener('submit', e => {
            e.preventDefault();
            const name = document.getElementById('name-holder').value;
            const icon = document.getElementById('icon-holder').value;
            const color = document.getElementById('color-holder').value;
            console.log(name);
            console.log(icon);
            console.log(color);
            document.getElementById('name').value = name;
            document.getElementById('icon').value = icon;
            document.getElementById('color').value = color;
            submitAddForm.submit();
        });

        closeAddRow.addEventListener('click', () => {
            addTechnologyRow.classList.add('d-none');
            addButton.disabled = false;
        });

    </script>

    <script>
        //EDIT TYPE SCRIPT
        
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const nameHolder = document.querySelector(`#technology-${id}-row .name`);
                const nameEditorRow = document.querySelector(`#technology-${id}-row .name-edit`);
                const nameEditor = document.querySelector(`#technology-${id}-row .name-edit input`);
                const iconHolder = document.querySelector(`#technology-${id}-row .icon`);
                const iconEditorRow = document.querySelector(`#technology-${id}-row .icon-edit`);
                const iconEditor = document.querySelector(`#technology-${id}-row .icon-edit input`)
                const colorHolder = document.querySelector(`#technology-${id}-row .color`);
                const editForm = document.querySelector(`#technology-${id}-row .edit-form`);
                const nameSender = document.querySelector(`#technology-${id}-row .edited-name`);
                const iconSender = document.querySelector(`#technology-${id}-row .edited-icon`);
                const colorSender = document.querySelector(`#technology-${id}-row .edited-color`);
                const closeEdit = document.querySelector(`#technology-${id}-row .btn-close-edit`);
                nameHolder.classList.add('d-none');
                nameEditorRow.classList.remove('d-none');
                iconHolder.classList.add('d-none');
                iconEditorRow.classList.remove('d-none');
                colorHolder.disabled = false;
                button.classList.add('d-none');
                editForm.classList.remove('d-none');
                editForm.classList.add('d-inline');
                closeEdit.classList.remove('d-none');
                editForm.addEventListener('submit', e => {
                    e.preventDefault();
                    console.log(nameEditor.value);
                    nameSender.value = nameEditor.value;
                    iconSender.value = iconEditor.value;
                    colorSender.value = colorHolder.value;
                    editForm.submit();
                });
                closeEdit.addEventListener('click', () => {
                    nameHolder.classList.remove('d-none');
                    nameEditorRow.classList.add('d-none');
                    iconHolder.classList.remove('d-none');
                    iconEditorRow.classList.add('d-none');
                    colorHolder.disabled = true;
                    button.classList.remove('d-none');
                    editForm.classList.add('d-none');
                    editForm.classList.remove('d-inline');
                    closeEdit.classList.add('d-none');
                })
            })
        })

    </script>
@endsection