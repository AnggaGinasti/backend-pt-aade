<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function index()
    {
        return Peminjaman::all();
    }

    public function show($id)
    {
        return Peminjaman::findOrFail($id);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'nama_peminjam' => 'required|string',
            'nama_barang' => 'required|string',
            'tanggal_dipinjam' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $peminjaman = Peminjaman::create($request->all());

        return response()->json($peminjaman, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'nama_peminjam' => 'required|string',
            'nama_barang' => 'required|string',
            'tanggal_dipinjam' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->all());

        return response()->json($peminjaman, 200);
    }

    public function destroy($id)
    {
        // Temukan peminjaman berdasarkan ID atau gagal jika tidak ditemukan
        $peminjaman = Peminjaman::findOrFail($id);

        // Hapus peminjaman
        $peminjaman->delete();

        // Kembalikan response dengan pesan sukses dan status 200 (OK)
        return response()->json([
            'message' => 'Peminjaman berhasil dihapus'
        ], 200);
    }
    
}