@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1 class="m-0 text-dark">Saldo</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
            <li class="breadcrumb-item active" aria-current="page">Saldo</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('balance.deposit') }}" class="btn btn-primary"><i class="fas fa-donate"></i> Recarregar</a>
            @if ($amount > 0)
                <a href="{{ route('balance.withdraw') }}" class="btn btn-danger"><i class="fas fa-cash-register"></i> Sacar</a>
            @endif
            @if ($amount > 0)
                <a href="{{ route('balance.transfer') }}" class="btn btn-info"><i class="fas fa-exchange-alt"></i> Transferir</a>
            @endif
        </div>
        <div class="card-body">
            @include('admin.includes.alerts')
            <div class="small-box bg-success">
            <div class="inner">
                <h3>R$ {{ number_format($amount, 2 , ',', '') }}</h3>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
                <a href="#" class="small-box-footer">histórico <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop
