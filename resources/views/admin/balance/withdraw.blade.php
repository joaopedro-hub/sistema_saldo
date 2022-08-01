@extends('adminlte::page')

@section('title', 'Nova Retirada')

@section('content_header')
    <h1 class="m-0 text-dark">Fazer Retirada</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
            <li class="breadcrumb-item active" aria-current="page">Saldo</li>
            <li class="breadcrumb-item active" aria-current="page">Sacar</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
         <div class="card-header">
            <h3>Fazer Retirada</h3>
        </div>
        <div class="card-body">
            @include('admin.includes.alerts')

            <form method="POST" action="{{ route('withdraw.store') }}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input type="text" name="value" placeholder="Valor da Retirada" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Sacar</button>
                </div>
            </form>
        </div>
    </div>
    <div>
        <a href="{{ route('balance') }}" class="btn btn-primary"> <i class="fas fa-arrow-left"></i> Voltar</a>
    </div>
@stop
