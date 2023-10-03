<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RusiaController extends Controller
{

    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $campos = $request->validate([
            'user' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('name', $request->user)->get()->first();

        try {
            if (Hash::check($request->password, $user->password)) {
                auth()->login($user, false);
                return redirect(route('menu'));
            }
        } catch (Exception $e) {
        }

        return redirect(route('login.view'))->withErrors(['error' => 'Usuario o clave incorrectos!']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function menu()
    {

        $tipos = Tipo::where('id_user',auth()->user()->id)->get();

        return view('menu', compact('tipos'));
    }

    public function insertar(Request $request)
    {

        $campos = $request->validate([
            'fecha' => ['required'],
            'tipos' => ['required'],
            'monto' => ['required']
        ]);


        $tipo = Tipo::where('nombre', $request->tipos)->where('id_user',auth()->user()->id)->get()->first();

        if (is_null($tipo)) {
            $new_tipo = Tipo::create([
                'nombre' => $request->tipos,
                'id_user'=>auth()->user()->id
            ]);
            $id_tipo = $new_tipo->id;
        } else {
            $id_tipo = $tipo->id;
        }

        Transaccion::create([
            'monto' => $request->monto,
            'fecha' => $request->fecha,
            'es_entrada' => $request->has('es_entrada'),
            'es_servicio' => $request->has('es_servicio'),
            'duracion' => $request->duracion,
            'id_tipo' => $id_tipo,
            'id_user' => auth()->user()->id
        ]);

        return redirect(route('menu'))->with('success', 'Transaccion guardada con exito!');
    }

    public function reportes(Request $request)
    {

        $fecha_actual = Carbon::now();
        $fecha_resta= Carbon::now();
        if (is_null($request->dias)) {
            $dias = 30;
        } else {
            $dias = $request->dias;
        }

        $entrada = Transaccion::where('es_entrada', 1)->where('id_user',auth()->user()->id)->sum('monto');
        $salida = Transaccion::where('es_entrada', 0)->where('id_user',auth()->user()->id)->sum('monto');

        $tipos = DB::table('Transaccion')
            ->join('Tipo', 'Transaccion.id_tipo', '=', 'Tipo.id')
            ->select(DB::raw('SUM(Transaccion.monto) as monto'), 'Tipo.nombre')
            ->whereDate('fecha','>',Carbon::now()->subDays($dias))
            ->where('Transaccion.es_entrada', 0)
            ->where('Transaccion.id_user',auth()->user()->id)
            ->groupBy('Tipo.nombre')
            ->havingRaw('SUM(Transaccion.monto) > 0')
            ->get();

        $maxTipo = 0;
        foreach ($tipos as $t) {
            if ($t->monto > $maxTipo) {
                $maxTipo = $t->monto;
            }
        }


        $transaccionesArr = DB::table('Transaccion')
            ->select('fecha', DB::raw('SUM(monto) as monto'))
            ->where('es_entrada', 0)
            ->where('id_user',auth()->user()->id)
            ->whereDate('fecha','>',Carbon::now()->subDays($dias))
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get();

        $diasArr = [];
        for ($i = 1; $i <= $dias; $i = $i + 1) {
            $diasArr[$i] = ['d'=>$i,'m'=>0];
            
            $fecha_resta = $fecha_resta->subDays($dias-$i);

            foreach ($transaccionesArr as $tr){
                if ($fecha_resta->isSameDay($tr->fecha)){
                    $diasArr[$i] = ['d'=>$i,'m'=>$tr->monto];
                }
            }
            $fecha_resta=Carbon::now();
        }


        $maxTr = 0;
        foreach ($transaccionesArr as $t) {
            if ($t->monto > $maxTr) {
                $maxTr = $t->monto;
            }
        }


        return view('reportes', compact('entrada', 'salida'))->with(compact('tipos', 'maxTipo'))
        ->with(compact('diasArr'))->with(compact('maxTr'));
    }
}
