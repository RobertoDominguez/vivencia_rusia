@extends('layouts.header') <!-- Asegúrate de que tu layout esté configurado -->

@section('content')
    <div class="container">
        <h1>Listado de Transacciones</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Es entrada</th>
                    <th>Es servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transacciones as $transaccion)
                    <tr>
                        <td>{{ $transaccion->monto }}</td>
                        <td>{{ $transaccion->fecha }}</td>
                        <td>{{ $transaccion->nombre }}</td>
                        @if ($transaccion->es_entrada==1)
                            <td>Entrada</td>
                        @else
                            <td>Salida</td>
                        @endif
                        @if ($transaccion->es_servicio==1)
                            <td>Servicio</td>
                        @else
                            <td>Compra</td>
                        @endif
                        <td>
                            <form action="{{ route('transacciones.destroy', $transaccion->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Mostrar los enlaces de paginación -->
    <div class="d-flex justify-content-center">
        {{ $transacciones->links() }}
    </div>
@endsection
