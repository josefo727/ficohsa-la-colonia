<?php

namespace App\Http\Controllers;

use App\Http\Requests\TdcFormRequest;
use Illuminate\Http\Request;

class TdcController extends Controller
{
    public function index()
    {
        $amount = rand(200, 900);

        return view('form', compact('amount'));
    }

    public function store(Request $request)
    {
        $sleep = rand(1,3);
        sleep($sleep);
        if (
            ($request->number ===  "4111 1111 1111 1111" && $request->mes === "12" && $request->year === "2025" && $request->ccv === "300")
            || ($request->number ===  "5555 5555 5555 4444" && $request->mes === "12" && $request->year === "2025" && $request->ccv === "999")
        ) {
            return response()->json(['message' => 'Transacción exitosa']);

        }

        return response()->json(['message' => 'error']);
    }
}
