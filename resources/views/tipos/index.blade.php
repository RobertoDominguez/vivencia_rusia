@extends('layouts.header') <!-- Asegúrate de que tu layout esté configurado -->

@section('content')


    <div class="container">
        <h1>Listado de Tipos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->nombre }}</td>
                        <td>
                            <form action="{{ route('tipos.destroy', $tipo->id) }}" method="POST" class="d-inline">
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
@endsection
