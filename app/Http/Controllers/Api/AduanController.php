<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AduanResource;
use App\Models\Aduan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    public function index()
    {
        $aduans = Aduan::with(['user', 'jenisAduan'])->latest()->paginate(10);
        return AduanResource::collection($aduans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_aduan_id' => 'required|exists:jenis_aduans,jenis_aduan_id',
            'aduan'          => 'required|string',
            'priority'       => 'required|in:low,medium,high',
        ]);

        // Otomatis mengambil user_id dari user yang sedang login via Sanctum
        $aduan = Aduan::create([
            'user_id'        => $request->user()->id,
            'jenis_aduan_id' => $validated['jenis_aduan_id'],
            'aduan'          => $validated['aduan'],
            'priority'       => $validated['priority'],
        ]);

        return new AduanResource($aduan->load(['user', 'jenisAduan']));
    }

    public function show($id)
    {
        $aduan = Aduan::with(['user', 'jenisAduan'])->findOrFail($id);
        return new AduanResource($aduan);
    }

    public function destroy($id)
    {
        $aduan = Aduan::findOrFail($id);
        $aduan->delete();

        return response()->json(['message' => 'Aduan berhasil dihapus']);
    }
}