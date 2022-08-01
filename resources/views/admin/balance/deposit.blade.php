@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1 class="m-0 text-dark">Fazer Recarga</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
            <li class="breadcrumb-item active" aria-current="page">Saldo</li>
            <li class="breadcrumb-item active" aria-current="page">Recarregar</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
         <div class="card-header">
            <h3>Fazer Recarga</h3>
        </div>

        <div class="card-body">
            @include('admin.includes.alerts')

            <form method="POST" action="{{ route('deposit.store') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="text" name="value" placeholder="Valor da Recarga" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Recarregar</button>
                </div>
            </form>
        </div>
    </div>
    <div>
        <a href="{{ route('balance') }}" class="btn btn-primary"> <i class="fas fa-arrow-left"></i> Voltar</a>
    </div>
@stop
