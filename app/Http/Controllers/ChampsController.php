<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Champs; 
use Illuminate\Http\Request;

class ChampsController extends Controller
{
    public function indexAdminChamps(Request $request)
    {
       
        $sortField = $request->input('sort', 'date'); 
        $sortDirection = $request->input('direction', 'asc'); 


        $champs = Champs::with('user')
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        $users = User::all();

        return view('pages.champs.indexAdmin', compact('champs', 'users', 'sortField', 'sortDirection'));
    }

    public function indexUserChamps(Request $request)
    {

        $sortField = $request->input('sort', 'date'); 
        $sortDirection = $request->input('direction', 'asc'); 


        $champs = Champs::with('user')
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('pages.champs.indexUser', compact('champs', 'sortField', 'sortDirection'));
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

        Champs::create([
            'user_id' => $request->input('user_id'),
            'date' => $request->input('date'),
            'weight' => $request->input('weight'),
        ]);

        return redirect()->route('pages.champs.indexAdminChamps')->with('success', 'Winner has been selected successfully.');
    }
}

