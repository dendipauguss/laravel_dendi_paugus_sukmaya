<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;

class RumahSakitController extends Controller
{
    public function index()
    {
        $rumah_sakit = RumahSakit::all();
        return view('rumah_sakit.index', compact('rumah_sakit'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'nullable|email',
            'telepon' => 'nullable|string|max:20',
        ]);

        $rs = RumahSakit::create($request->all());
        return response()->json($rs);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $rs = RumahSakit::find($id);
        if (!$rs) return response()->json(['error' => 'Data tidak ditemukan'], 404);
        return response()->json($rs);
    }

    public function update(Request $request, $id)
    {
        $rs = RumahSakit::find($id);
        if (!$rs) return response()->json(['error' => 'Data tidak ditemukan'], 404);

        $rs->update($request->all());
        return response()->json($rs);
    }

    public function destroy($id)
    {
        $rs = RumahSakit::find($id);
        if (!$rs) return response()->json(['error' => 'Data tidak ditemukan'], 404);

        $rs->delete();
        return response()->json(['success' => true]);
    }
}
