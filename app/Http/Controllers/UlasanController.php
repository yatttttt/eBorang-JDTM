<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with(['permohonan', 'userPengulas'])->get();
        return response()->json($ulasans);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_permohonan' => 'required|exists:permohonans,id_permohonan',
            'id_user_pengulas' => 'required|exists:users,id_user',
            'peranan_pengulas' => 'required|in:pengarah,pegawai',
            'ulasan' => 'required|string',
            'status' => 'required|string|max:50',
        ]);

        $ulasan = Ulasan::create($data);

        return response()->json($ulasan, 201);
    }

    public function show($id)
    {
        $ulasan = Ulasan::with(['permohonan', 'userPengulas'])->findOrFail($id);
        return response()->json($ulasan);
    }

    public function update(Request $request, $id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->update($request->all());

        return response()->json($ulasan);
    }

    public function destroy($id)
    {
        Ulasan::destroy($id);
        return response()->json(['message' => 'Ulasan deleted successfully']);
    }
}
