
@if ($project->exists)
    <form class="card bg-secondary text-light p-5" action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
@else
    <form class="card bg-secondary text-light p-5" action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
@endif
    @csrf
    <div class="row mb-5">
        <div class="col-6 px-5 d-flex flex-column mb-3">
            <label class="text-start mb-2" for="name">Project Name</label>
            <input type="text" id="name" name="name" placeholder="Insert project name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $project->name) }}">
            @error('name')
            <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-6 px-5 d-flex flex-column mb-3">
            <label class="text-start mb-2" for="project_url">Project Url</label>
            <input type="text" id="project_url" name="project_url" placeholder="Insert project url" class="form-control @error('project_url') is-invalid @enderror" value="{{ old('project_url', $project->project_url) }}">
            @error('project_url')
            <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-6 px-5 d-flex flex-column">
            <label class="text-start mb-2" for="type_id">Type</label>
            <select class="form-control mb-3" name="type_id" id="type_id">
                <option value="">No type</option>
                @foreach ($types as $type)
                    <option @if(old('type_id', $project->type?->id) == $type->id) selected @endif value="{{$type->id}}">{{$type->label}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 px-5 d-flex flex-column">
            <label class="text-start mb-2">Technologies</label>
            <div class="row gy-3 px-5">
                @foreach ( $technologies as $technology )
                    <div class="col-3 form-check text-start">
                        <input class="form-check-input" type="checkbox" value="{{ $technology->id }}" id="{{ $technology->id }}" name="technologies[]" @if (in_array(($technology->id), old('technologies', $project_technologies ?? []))) checked @endif >
                        <label class="form-check-label" for="{{ $technology->id }}">{{ $technology->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 px-5 d-flex flex-column mb-3">
            <label class="text-start mb-2" for="description">Project Description</label>
            <textarea class="p-2 form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="10" placeholder="Insert project description">{{ old('description', $project->description) }}</textarea>
            @error('description')
            <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="img-load d-flex align-items-center">
            <div class="col-6 offset-2 px-5 d-flex flex-column">
                <label class="text-start mb-2" for="image_url">Image</label>
                <input type="file" id="image_url" name="image_url" class="form-control">
            </div>
            <div class="col-2">
                <img id="preview-image" class="img-fluid" src="{{ $project->image_url ? $project->getImageUrl() : 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/681px-Placeholder_view_vector.svg.png' }}" alt="placeholder">
            </div>
        </div>
    </div>
    <hr>
    <div class="buttons d-flex justify-content-end px-5">
        <a class="btn btn-small btn-primary me-3" href="{{ route('admin.projects.index') }}">Back</a>
        <button type="submit" class="btn btn-small btn-success"><i class="fa-regular fa-floppy-disk"></i> Save</button>
    </div>
</form>

@section('scripts')
<script>
const imageInput = document.getElementById('image_url');
    const imagePreview = document.getElementById('preview-image');
    imageInput.addEventListener('change', () => {
        if (imageInput.files && imageInput.files[0]) { 
            const reader = new FileReader();
            reader.readAsDataURL(imageInput.files[0]);
            reader.addEventListener('load', e => {
                imagePreview.setAttribute('src', e.target.result);
            });
        } else {
            imagePreview.setAttribute('src', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/681px-Placeholder_view_vector.svg.png');
        }
    });
        
</script>
    
@endsection
