<?php

namespace App\Http\Controllers;

use App\Models\Kritik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KritikController extends Controller
{
    public function create()
    {
        return view('kritik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        Kritik::create([
            'user_id' => Auth::id(),  
            'date' => $request->input('date'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        return redirect()->route('pages.kritik.index.user')->with('success', 'Kritik dan saran telah dikirim.');
    }

    public function indexAdmin()
    {

        $kritik = Kritik::with('user')->paginate(10); 
        return view('pages.kritikdansaran.indexAdmin', compact('kritik'));
    }
    
    
    public function indexUser()
    {
        $kritik = Kritik::where('user_id', Auth::id())->get();
        return view('pages.kritikdansaran.indexUser', compact('kritik'));
    }
}
