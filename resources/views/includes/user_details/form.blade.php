<div class="card bg-secondary text-light p-5">
    @if (Auth::user()->userDetail)
        <form class="row" action="{{ route('admin.user_details.update', Auth::user()->userDetail->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
    @else
        <form class="row" action="{{ route('admin.user_details.store') }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        <div class="col-6 d-flex flex-column text-start px-5 mb-3">
            <label class="mb-2" for="first_name">Name</label>
            <input class="form-control" type="text" id="first_name" name="first_name" value="{{ old('first_name', Auth::user()->userDetail?->first_name) }}">
        </div>
        <div class="col-6 d-flex flex-column text-start px-5 mb-3">
            <label class="mb-2" for="last_name">Surname</label>
            <input class="form-control" type="text" id="last_name" name="last_name" value="{{ old('last_name', Auth::user()->userDetail?->last_name) }}">
        </div>
        <div class="col-12 d-flex flex-column text-start px-5 mb-3">
            <label class="mb-2" for="address">Address</label>
            <input class="form-control" type="text" id="address" name="address" value="{{ old('address', Auth::user()->userDetail?->address) }}">
        </div>
        <div class="col-6 d-flex flex-column text-start px-5 mb-3">
            <label class="mb-2" for="profile_pic">Profile Pic</label>
            <input class="form-control" type="file" id="profile_pic" name="profile_pic">
        </div>
        @if (!Auth::user()->userDetail)
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        @endif
        <hr>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-success me-2">Salva</button>
            <a class="btn btn-primary" href="{{ route('admin.home') }}">Back</a>
        </div>
    </form>