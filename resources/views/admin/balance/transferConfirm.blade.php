@extends('adminlte::page')

@section('title', 'Confirmar Nova Transferência')

@section('content_header')
    <h1 class="m-0 text-dark">Confirmar Transferência</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
            <li class="breadcrumb-item active" aria-current="page">Saldo</li>
            <li class="breadcrumb-item active" aria-current="page">Transferir</li>
            <li class="breadcrumb-item active" aria-current="page">Confirmação</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
         <div class="card-header">
            <h3>Confirmar Transferência Saldo</h3>
        </div>
        <div class="card-body">
            @include('admin.includes.alerts')

            <p><strong>Recebedor: </strong>{{$sender->name }}</p>
            <p><strong>Seu saldo atual é:</strong> R$ {{ number_format($balance->amount, 2,',','.') }}</p>


            <form method="POST" action="{{ route('tranfer.store') }}">

                {!! csrf_field() !!}
                <input type="hidden" name="sender_id" value="{{$sender->id }}">
                <div class="form-group">
                    <input type="text" name="value" placeholder="Valor: " class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Transferir</button>
                </div>
            </form>
        </div>
    </div>
@stop
