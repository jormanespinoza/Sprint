{{-- Success messages --}}
@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        <strong><span class="glyphicon glyphicon-ok-sign"></span> Éxito:</strong> {{ Session::get('success') }}
    </div>
@endif

{{-- Errors messages --}}
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul class="user-system-errors">
            @foreach($errors->all() as $error)
                <li><span class="glyphicon glyphicon-info-sign"></span> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif