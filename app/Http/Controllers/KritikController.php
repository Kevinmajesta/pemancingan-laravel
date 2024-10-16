<?php

namespace App\Http\Controllers;

use App\Models\Kritik;
use App\Models\User; // Tambahkan ini untuk mengakses model User
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

        return redirect()->route('pages.kritik.indexUser')->with('success', 'Kritik dan saran telah dikirim.');
    }

    public function indexAdmin(Request $request)
    {
        $sortField = $request->input('sort', 'date');
        $sortDirection = $request->input('direction', 'asc');

        $kritik = Kritik::with('user')
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        $users = User::all(); // Ambil data users

        return view('pages.kritikdansaran.indexAdmin', compact('kritik', 'users', 'sortField', 'sortDirection'));
    }

    public function indexUser(Request $request)
    {
        $sortField = $request->input('sort', 'date');
        $sortDirection = $request->input('direction', 'asc');

        $kritik = Kritik::where('user_id', Auth::id())
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('pages.kritikdansaran.indexUser', compact('kritik', 'sortField', 'sortDirection'));
    }
}

