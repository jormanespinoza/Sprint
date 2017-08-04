{{-- Success messages --}}
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><span class="glyphicon glyphicon-ok-sign"></span> Éxito:</strong> {{ Session::get('success') }}
    </div>
@endif

{{-- Errors messages --}}

{{--
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul class="user-system-errors">
            @foreach($errors->all() as $error)
                <li><span class="glyphicon glyphicon-alert"></span> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 
--}}