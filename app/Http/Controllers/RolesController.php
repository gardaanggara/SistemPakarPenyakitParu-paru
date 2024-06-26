<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;


class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman master roles
        $roleList = Roles::all();
        // dd($roleList);
        return view('roles.dashboardRoles', $roleList);
    }

    // Api Data Role 
    public function getData()
    {
        // Mengambil data role
        $roleList = Roles::all()->map(function ($role) {
            $role->aksi = '
                <button class="btn btn-primary btn-sm edit-btn" data-id="' . $role->id . '">
                    <ion-icon name="create-outline"></ion-icon>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $role->id . '">
                    <ion-icon name="trash-outline"></ion-icon>
                </button>';
            return $role;
        });
        return response()->json($roleList);
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
            'id' => 'nullable|exists:roles,id',
            'keterangan' => 'required|string'
        ]);

        if ($request->filled('id')) {
            // Jika ID ada, update item yang sudah ada
            $item = Roles::find($request->id);
            if ($item) {
                $item->keterangan = $request->keterangan;
                $item->save();
                return redirect()->back()->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }
        } else {
            // Jika ID tidak ada, buat item baru
            $item = new Roles;
            $item->keterangan = $request->keterangan;
            $item->save();
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        }
    }

    public function getRoleById($id)
    {
        $role = Roles::find($id);
        return response()->json($role);
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
        $item = Roles::find($id);
        
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }    
}
