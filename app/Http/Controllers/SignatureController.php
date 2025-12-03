<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignatureController extends Controller
{
    /**
     * Show the form for creating a new signature.
     */
    public function create()
    {
        return view('signature.create'); // atau view lain
    }

    /**
     * Store a newly created signature.
     */
    public function store(Request $request)
    {
        // Logic untuk menyimpan signature
        $signatureData = $request->input('signature');
        
        // Simpan ke database atau session
        session(['user_signature' => $signatureData]);
        
        return redirect()->back()->with('success', 'Signature saved!');
    }

    /**
     * Display the signature pad.
     */
    public function index()
    {
        return view('signature.index');
    }
}