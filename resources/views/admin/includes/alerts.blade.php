{{-- verificação de erros --}}
@if ($errors->any()) {{-- retorna true caso tenha erro e false caso não tenha --}}
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
