@if ($errors->any())
        <div class="col-12 alert alert-danger mb-3 container p-3 text-start">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif