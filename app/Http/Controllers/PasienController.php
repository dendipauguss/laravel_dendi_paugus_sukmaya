<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $rs_id = $request->get('rumah_sakit_id');
        $rumahSakit = RumahSakit::all();

        $pasien = Pasien::with('rumahSakit')
            ->when($rs_id, function ($query, $rs_id) {
                return $query->where('rumah_sakit_id', $rs_id);
            })
            ->get();

        if ($request->ajax()) {
            return response()->json($pasien);
        }

        return view('pasien.index', compact('pasien', 'rumahSakit'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telpon' => 'required|string|max:20',
            'rumah_sakit_id' => 'required|exists:rumah_sakit,id',
        ]);

        $pasien = Pasien::create([
            'nama_pasien' => $request->nama_pasien,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'rumah_sakit_id' => $request->rumah_sakit_id,
        ]);

        $pasien->load('rumahSakit'); // supaya relasi RS bisa dikirim

        return response()->json($pasien);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) return response()->json(['error' => 'Data tidak ditemukan'], 404);

        return response()->json($pasien);
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) return response()->json(['error' => 'Data tidak ditemukan'], 404);

        $pasien->update([
            'nama_pasien' => $request->nama_pasien,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'rumah_sakit_id' => $request->rumah_sakit_id,
        ]);

        // Mengembalikan data lengkap termasuk relasi rumahSakit
        $pasien->load('rumahSakit');

        return response()->json($pasien);
    }

    public function destroy($id)
    {
        $pasien = Pasien::find($id);

        if (!$pasien) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $pasien->delete();

        return response()->json(['success' => true]);
    }
}
