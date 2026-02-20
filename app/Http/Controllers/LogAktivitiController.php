<?php

namespace App\Http\Controllers;

use App\Models\LogAktiviti;
use Illuminate\Http\Request;

class LogAktivitiController extends Controller
{
    public function index()
    {
        $logs = LogAktiviti::with('user')->get();
        return response()->json($logs);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'tindakan' => 'required|string',
        ]);

        $log = LogAktiviti::create($data);

        return response()->json($log, 201);
    }

    public function show($id)
    {
        $log = LogAktiviti::with('user')->findOrFail($id);
        return response()->json($log);
    }

    public function destroy($id)
    {
        LogAktiviti::destroy($id);
        return response()->json(['message' => 'Log deleted successfully']);
    }
}
