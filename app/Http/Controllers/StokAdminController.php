<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StokAdminController extends Controller
{
    public function index()
    {
        $produk = Produk::query()->latest('id')->get();
        $stok = $produk->pluck('stok')->map(fn ($n) => (int) $n);

        return view('admin.stok', [
            'produk' => $produk,
            'jumlahProduk' => $produk->count(),
            'totalStok' => $stok->sum(),
            'jumlahMenipis' => $stok->filter(fn ($n) => $n > 0 && $n <= 5)->count(),
            'jumlahHabis' => $stok->filter(fn ($n) => $n === 0)->count(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['snack', 'drink'])],
            'harga' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'stok' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.stok')->with('sukses', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(['snack', 'drink'])],
            'harga' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'stok' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.stok')->with('sukses', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('admin.stok')->with('sukses', 'Produk berhasil dihapus.');
    }
}
