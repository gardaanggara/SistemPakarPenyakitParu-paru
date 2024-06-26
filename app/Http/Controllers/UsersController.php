<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman master users
        $usersList = User::all();
        // dd($usersList);
        return view('users.dashboardUsers', $usersList);
    }

    // Api Data User 
    public function getData()
    {
        // Mengambil data user
        $usersList = User::all()->map(function ($user) {
            $user->aksi = '
                <button class="btn btn-primary btn-sm edit-btn" data-id="' . $user->id . '">
                    <ion-icon name="create-outline"></ion-icon>
                </button>
                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $user->id . '">
                    <ion-icon name="trash-outline"></ion-icon>
                </button>';
            return $user;
        });
        return response()->json($usersList);
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
            'id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:8|confirmed', // Ubah validasi password
        ]);
    
        if ($request->filled('id')) {
            // Jika ID ada, update item yang sudah ada
            $item = User::find($request->id);
            if ($item) {
                $item->name = $request->name;
                $item->email = $request->email;
                if ($request->password) { // Hanya update password jika diisi
                    $item->password = bcrypt($request->password);
                }
                $item->save();
                return redirect()->back()->with('success', 'Data berhasil diupdate.');
            } else {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }
        } else {
            // Jika ID tidak ada, buat item baru
            $item = new User;
            $item->name = $request->name;
            $item->email = $request->email;
            $item->password = bcrypt($request->password); // Hash password baru
            $item->save();
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        }
    }
     

    public function getUserById($id)
    {
        $user = User::find($id);
        return response()->json($user);
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
        $item = User::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }    
}
