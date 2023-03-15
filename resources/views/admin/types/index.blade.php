@extends('layouts.main')

@section('title', 'TYPES')
    
@section('content')

<div class="container py-5 text-center">
    <h1>Types</h1>
    @include('includes.alerts.errors')
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Type Name</th>
            <th scope="col">Color</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="types-table">
            @forelse ($types as $type)
            <tr id="type-{{$type->id}}-row">
                <th class="align-middle" scope="row">{{ $type->id }}</th>
                <td class="label align-middle">{{ $type->label }}</td>
                <td class="label-edit align-middle d-none"><input type="text" value="{{ $type->label }}"></td>
                <td class="align-middle"><input class="color" type="color" name="color" value="{{ $type->color }}" disabled></td>
                <td class="align-middle">{{ $type->created_at }}</td>
                <td class="align-middle">{{ $type->updated_at }}</td>
                <td class="align-middle">
                    <button class="btn btn-edit btn-warning" data-id="{{ $type->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                    <form class="d-none edit-form" action="{{ route('admin.types.update', $type->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input class="edited-label" type="hidden" name="label">
                        <input class="edited-color" type="hidden" name="color">
                        <button class="btn btn-edit btn-success" ><i class="fa-solid fa-check"></i></button>
                    </form>
                    <button class="btn btn-close-edit btn-secondary d-none"><i class="fa-solid fa-xmark"></i></button>
                    <form class="d-inline delete-form" action="{{ route('admin.types.destroy', $type->id) }}" method="POST" data-project-name="{{ $type->label }}">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-small btn-danger"><i class="fa-regular fa-trash-can"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <th scope="row" colspan="6" class="text-center">Non ci sono tipi</th>
            </tr> 
            @endforelse  
            <tr id="add-type-row" class="d-none">   
                <th class="align-middle" scope="row"></th>
                <td class="align-middle"><input id="label-holder" type="text"></td>
                <td class="align-middle"><input id="color-holder" type="color"></td>
                <td class="align-middle"></td>
                <td class="align-middle"></td>
                <td class="align-middle d-flex justify-content-center align-items-center"> 
                    <form id="submit-add-form" action="{{route('admin.types.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="label" id="label">
                        <input type="hidden" name="color" id="color">
                        <button class="btn btn-small btn-success me-2"><i class="fa-solid fa-check"></i></button>
                    </form>
                    <button id="close-add-row" class="btn btn-small btn-danger"><i class="fa-solid fa-xmark"></i></button>
                </td>
            </tr>       
        </tbody>
    </table>

    <div class="buttons d-flex justify-content-end mb-5">
        <button id="add-type" class="btn btn-small btn-success"><i class="fa-solid fa-plus"></i></button>
    </div>

    <div class="offset-9 col-3" >{{ $types->links() }}</div>

    @include('includes.projects.delete-modal')

</div>
    
@endsection

@section('scripts')
    <script>
        //ADD TYPE SCRIPT

        const addTypeRow = document.getElementById('add-type-row')
        const addButton = document.getElementById('add-type');
        const submitAddForm = document.getElementById('submit-add-form');
        const closeAddRow = document.getElementById('close-add-row');

        addButton.addEventListener('click', () => {
            addTypeRow.classList.remove('d-none');
            addButton.disabled = true;
        });

        submitAddForm.addEventListener('submit', e => {
            e.preventDefault();
            const label = document.getElementById('label-holder').value;
            const color = document.getElementById('color-holder').value;
            console.log(label);
            console.log(color);
            document.getElementById('label').value = label;
            document.getElementById('color').value = color;
            submitAddForm.submit();
        });

        closeAddRow.addEventListener('click', () => {
            addTypeRow.classList.add('d-none');
            addButton.disabled = false;
        });

    </script>

    <script>
        //EDIT TYPE SCRIPT
        
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const labelHolder = document.querySelector(`#type-${id}-row .label`);
                const labelEditorRow = document.querySelector(`#type-${id}-row .label-edit`);
                const labelEditor = document.querySelector(`#type-${id}-row .label-edit input`);
                const colorHolder = document.querySelector(`#type-${id}-row .color`);
                const editForm = document.querySelector(`#type-${id}-row .edit-form`);
                const labelSender = document.querySelector(`#type-${id}-row .edited-label`);
                const colorSender = document.querySelector(`#type-${id}-row .edited-color`);
                const closeEdit = document.querySelector(`#type-${id}-row .btn-close-edit`);
                labelHolder.classList.add('d-none');
                labelEditorRow.classList.remove('d-none');
                colorHolder.disabled = false;
                button.classList.add('d-none');
                editForm.classList.remove('d-none');
                editForm.classList.add('d-inline');
                closeEdit.classList.remove('d-none');
                editForm.addEventListener('submit', e => {
                    e.preventDefault();
                    console.log(labelEditor.value);
                    labelSender.value = labelEditor.value;
                    colorSender.value = colorHolder.value;
                    editForm.submit();
                });
                closeEdit.addEventListener('click', () => {
                    labelHolder.classList.remove('d-none');
                    labelEditorRow.classList.add('d-none');
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


