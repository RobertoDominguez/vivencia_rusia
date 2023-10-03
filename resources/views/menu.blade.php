@extends('layouts.header')

@section('content')
    <div class="container">
        <br>
        <h1>Transacciones</h1>
        <br>
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('transaccion.insertar') }}" method="POST">
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="tipos" class="form-label">Tipo de Transaccion:</label>
                <input type="text" class="form-control" id="dia_semana_input" name="tipos" list="tipo"
                    placeholder="Escribe o selecciona el Tipo">
                <datalist id="tipo">
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->nombre }}">
                    @endforeach

                </datalist>
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto:</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="es_entrada" class="form-check-label">Es entrada: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </label>

                <input type="checkbox" class="form-check-input" id="es_entrada" name="es_entrada" value="1">
            </div>
            <div class="mb-3">
                <label for="es_servicio" class="form-check-label">Es servicio &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </label>
                <input type="checkbox" class="form-check-input" id="es_servicio" name="es_servicio" value="1">
            </div>
            <div class="mb-3">
                <label for="duracion" class="form-label">Duración:</label>
                <input type="number" class="form-control" id="duracion" name="duracion" value="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
@endsection
