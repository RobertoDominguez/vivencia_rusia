<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Http\Requests\StoreTransaccionRequest;
use App\Http\Requests\UpdateTransaccionRequest;

class TransaccionController extends Controller
{

    public function indexWeb()
    {
        $transacciones = Transaccion::join('Tipo','Tipo.id','Transaccion.id_tipo')->orderBy('Transaccion.id', 'desc')->select('Transaccion.*','Tipo.nombre')->paginate(20);
        return view('transacciones.index', compact('transacciones'));
    }

    public function destroyWeb(Transaccion $transaccion)
    {
        $transaccion->delete();
        return redirect()->route('transacciones.index')->with('success', 'La transacción ha sido eliminada con éxito.');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransaccionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaccion $transaccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaccion $transaccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransaccionRequest $request, Transaccion $transaccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaccion $transaccion)
    {
        //
    }
}
