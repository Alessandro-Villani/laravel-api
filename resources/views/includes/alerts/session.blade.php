@if (session('message'))
    <div class="container mt-5 text-center">
        <div class="alert alert-{{ session('type') }}">{!! session('message') !!}</div>
    </div>
@endif