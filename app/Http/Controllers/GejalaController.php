<?php

namespace App\Http\Controllers;

use App\Models\Gejalas;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman master gejalas
        $gejalaList = Gejalas::all();
        // dd($gejalaList);
        return view('gejalas.dashboardGejalas', $gejalaList);
    }

    // Api Data Gejala 
    public function getData()
    {
        // Mengambil data gejala
        $gejalaList = Gejalas::all()->map(function ($gejala) {
            $gejala->aksi = '
                <button class="btn btn-primary btn-sm edit-btn" data-id="' . $gejala->id . '">
                    <ion-icon name="create-outline"></ion-icon>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $gejala->id . '">
                    <ion-icon name="trash-outline"></ion-icon>
                </button>';
            return $gejala;
        });
        return response()->json($gejalaList);
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
            'id' => 'nullable|exists:gejalas,id',
            'nama_gejala' => 'required|string'
        ]);

        if ($request->filled('id')) {
            // Jika ID ada, update item yang sudah ada
            $item = Gejalas::find($request->id);
            if ($item) {
                $item->nama_gejala = $request->nama_gejala;
                $item->save();
                return redirect()->back()->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }
        } else {
            // Jika ID tidak ada, buat item baru
            $item = new Gejalas;
            $item->nama_gejala = $request->nama_gejala;
            $item->save();
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        }
    }

    public function getGejalaById($id)
    {
        $gejala = Gejalas::find($id);
        return response()->json($gejala);
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
        $item = Gejalas::find($id);
        
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }    
}
