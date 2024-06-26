<?php

namespace App\Http\Controllers;

use App\Models\Penyakits;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman master penyakits
        $penyakitList = Penyakits::all();
        // dd($penyakitList);
        return view('penyakits.dashboardPenyakits', $penyakitList);
    }

    // Api Data Penyakit 
    public function getData()
    {
        // Mengambil data penyakit
        $penyakitList = Penyakits::all()->map(function ($penyakit) {
            $penyakit->aksi = '
                <button class="btn btn-primary btn-sm edit-btn" data-id="' . $penyakit->id . '">
                    <ion-icon name="create-outline"></ion-icon>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $penyakit->id . '">
                    <ion-icon name="trash-outline"></ion-icon>
                </button>';
            return $penyakit;
        });
        return response()->json($penyakitList);
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
    public function storeOrUpdate(Request $request, $id = NULL)
    {
        // Validasi data yang masuk
        $request->validate([
            'id' => 'nullable|exists:penyakits,id',
            'nama_penyakit' => 'required|string'
        ]);

        if ($request->filled('id')) {
            // Jika ID ada, update item yang sudah ada
            $item = Penyakits::find($request->id);
            if ($item) {
                $item->nama_penyakit = $request->nama_penyakit;
                $item->save();
                return redirect()->back()->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }
        } else {
            // Jika ID tidak ada, buat item baru
            $item = new Penyakits;
            $item->nama_penyakit = $request->nama_penyakit;
            $item->save();
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        }
    }

    public function getGejalaById($id)
    {
        $penyakit = Penyakits::find($id);
        return response()->json($penyakit);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Penyakits::find($id);
        
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }    
}
