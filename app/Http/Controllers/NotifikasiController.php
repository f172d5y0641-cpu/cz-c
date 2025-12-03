<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        return Notifikasi::all();
    }

    public function store(Request $request)
    {
        $notifikasi = Notifikasi::create($request->all());
        return response()->json($notifikasi, 201);
    }

    public function show($id)
    {
        return Notifikasi::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->update($request->all());
        return response()->json($notifikasi, 200);
    }

    public function destroy($id)
    {
        Notifikasi::destroy($id);
        return response()->json(null, 204);
    }
}
