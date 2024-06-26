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
    public function store(Request $request, $id = null)
    {
        // Validasi inputan
        $request->validate([
            'keterangan' => ['required', 'string', 'max:255']
        ]);

        // Ambil ID dari request
        $role_id = $request->input('role_id');

        // Lakukan operasi insert atau update sesuai dengan keberadaan ID
        if ($role_id) {
            // Jika ID tersedia, lakukan update
            $role = Roles::find($role_id);

            // Periksa apakah data ditemukan
            if ($role) {
                // Update data
                $role->update([
                    'keterangan' => $request->keterangan
                    // Tambahkan kolom lain yang perlu diupdate di sini
                ]);

                return redirect(route('dashboardRoles'))->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect(route('dashboardRoles'))->with('error', 'Data tidak ditemukan.');
            }
        } else {
            // Jika ID tidak tersedia, lakukan insert
            $role = Roles::create([
                'keterangan' => $request->keterangan
            ]);

            return redirect(route('dashboardRoles'))->with('success', 'Data berhasil disimpan.');
        }
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
    public function destroy(string $id)
    {
        //
    }
}
