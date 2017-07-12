{{-- Success messages --}}
@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        <strong>Éxito:</strong> {{ Session::get('success') }}
    </div>
@endif

{{-- Errors messages --}}
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif