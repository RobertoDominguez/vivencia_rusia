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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transacciones as $transaccion)
                    <tr>
                        <td>{{ $transaccion->monto }}</td>
                        <td>{{ $transaccion->fecha }}</td>
                        <td>{{ $transaccion->id_tipo }}</td>
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
