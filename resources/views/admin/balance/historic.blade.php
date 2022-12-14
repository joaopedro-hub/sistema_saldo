@extends('adminlte::page')

@section('title', 'Histórico de Movimentações')

@section('content_header')
    <h1 class="m-0 text-dark">Histórico de Movimentações</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
            <li class="breadcrumb-item active" aria-current="page">Histórico</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            {{-- Filtros --}}
            <form action="{{ route('historic.search') }}" method="POST" class="form form-inline">
                {!! csrf_field() !!} {{-- token --}}

                <input type="text" name="id" class="form-control" placeholder="ID" style="margin-right: 0.5%">
                <input type="date" name="date" class="form-control" style="margin-right: 0.5%">
                <select name="type" class="form-control" style="margin-right: 0.5%">
                    <option value="">-- Selecione o tipo --</option>
                    @foreach ($types as $key => $type)
                        <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Remetente</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historics as $historic)

                    <tr>
                        <td>{{ $historic->id }}</td>
                        <td>{{ number_format($historic->amount,2,',','.') }}</td>
                        <td>{{ $historic->type($historic->type) }}</td>
                        <td>{{ $historic->date }}</td>
                        <td>
                            @if ($historic->user_id_transaction)
                                    {{ $historic->userSender->name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            @if (isset($dataForm))
                {{-- todos os dados do dataForm vai passar por parâmetro na url --}}
                {{$historics->appends($dataForm)->links() }}
            @else
                {{-- exibir a paginação --}}
            {{ $historics->links() }}
            @endif
        </div>
    </div>
@stop
