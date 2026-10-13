<?php

namespace App\Http\Controllers;

use App\Models\StokProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StokAdminController extends Controller
{
    /**
     * Menampilkan daftar stok produk.
     */
    public function index()
    {
        $stokProduk = StokProduk::latest()->get();
        return view('admin.stok.index', compact('stokProduk'));
    }

    /**
     * Menyimpan data produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'value'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'value']);

        // Olah file gambar jika diunggah
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('stok_produk', 'public');
        }

        StokProduk::create($data);

        return redirect()->route('stok.index')->with('success', 'Stok produk berhasil ditambahkan!');
    }

    /**
     * Memperbarui data produk dan mengganti gambar jika ada file baru.
     */
    public function update(Request $request, $id)
    {
        $produk = StokProduk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'value'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'value']);

        // Jika unggah gambar baru, hapus gambar lama terlebih dahulu
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('stok_produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('stok.index')->with('success', 'Stok produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk beserta file gambarnya.
     */
    public function destroy($id)
    {
        $produk = StokProduk::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('stok.index')->with('success', 'Stok produk berhasil dihapus!');
    }
}