<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Champs; 
use Illuminate\Http\Request;

class ChampsController extends Controller
{

    public function indexAdminChamps()
    {
        $champs = Champs::with('user')->get(); 
        $users = User::all(); 
        return view('pages.champs.indexAdmin', compact('champs', 'users'));
    }
    public function indexUserChamps()
    {
        $champs = Champs::with('user')->paginate(10); 
        return view('pages.champs.indexUser', compact('champs'));
    }

    public function create()
    {
        $users = User::all();
        return view('pages.champs.create', compact('users')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'weight' => 'required|numeric|min:0',
        ]);

        // Logic to store the winner details
        Champs::create([
            'user_id' => $request->input('user_id'),
            'date' => $request->input('date'),
            'weight' => $request->input('weight'),
        ]);

        return redirect()->route('pages.champs.indexAdmin')->with('success', 'Winner has been selected successfully.');
    }
}

