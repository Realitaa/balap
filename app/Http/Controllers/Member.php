<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\View\View;

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
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus!');
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
        return redirect()->route('members.index')->with('success', 'Role member'. $user['name'] .' di update menjadi ' . ($role == 1 ? 'Admin' : 'Member'));
    }

    // Function for update the expired date
    public function updateExpiredDate($id)
    {
        $user = User::findOrFail($id);

        if (is_null($user->expired_date)) {
            $user->expired_date = now()->addYear();
        } else {
            $user->expired_date = $user->expired_date->addYear();
        }
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('members.index')->with('success', 'Masa aktif member berhasil diperpanjang!');
    }
}
