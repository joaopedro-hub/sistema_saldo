@extends('adminlte::page')

@section('title', 'Home Dashboard')

@section('content_header')

    <div class="form-row">
        <div class="col">
            <h1 class="m-0 text-dark">Dashboard</h1>
        </div>
        <div class="col" style="text-align: right">
        <a href="{{ route('home') }}" class="btn btn-primary" style="text-align: right;"> <i class="fas fa-arrow-left"></i> Home</a>
    </div>
    </div>


@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
@stop
