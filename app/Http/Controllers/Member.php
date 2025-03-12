<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Member extends Controller
{
    public function index() : View
    {
        //get all users
        $users = User::latest()->paginate(10);

        //render view with products
        return view('member', compact('users'));
    }

    //Function for delete member
    public function destroy($id = null)
    {
        if (!$id) {
            $id = Auth::user()->id;
        }
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Member berhasil di hapus!');
    }

    // Function for update the role
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:1,2',
        ]);

        $role = $request->role;

        if ($user->role == $role) {
            return response()->json([
                'success' => false,
                'message' => 'Role is already set to ' . ($role == 1 ? 'Admin' : 'Member')
            ]);
        }
        
        $user->role = $role;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('Role member'. $user['name'] .' di update menjadi ' . ($role == 1 ? 'Admin' : 'Member'));
    }

    // Function for update the expired date
    public function updateExpiredDate($id)
    {
        $user = User::findOrFail($id);

        if (is_null($user->expired_date)) {
            $user->expired_date = now()->addYear();
        } else {
            $user->expired_date = \Carbon\Carbon::parse($user->expired_date)->addYear();
        }
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Masa Aktif berhasil diperpanjang!');
    }

    // Function for update the basic information
    public function basic_update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Informasi Dasar berhasil diperbarui!');
    }

    // Function for update the additional information
    public function additional_update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'birthdate' => 'nullable|date_format:d-m-Y',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $user->birthdate = $request->birthdate ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->birthdate)->format('Y-m-d') : null;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->save();

        return redirect()->back()->with('success', 'Informasi Tambahan berhasil diperbarui!');
    }
}
