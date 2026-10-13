<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Stok - SnackinAja Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat:#A65510; --krem:#FFFDE9; --kartu:#F9F4D6; --gelap:#3A230F; --merah:#A3342E; --hijau:#4C8C2B; --oranye:#C77A12; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:Poppins,sans-serif; background:var(--krem); color:var(--coklat); }
        .bar { background:var(--coklat); min-height:70px; padding:12px 5%; display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
        .logo { color:#FFD9C7; font-weight:700; font-size:22px; text-decoration:none; margin-right:auto; }
        .bar a.tautan { color:white; font-weight:600; text-decoration:none; border:2px solid white; border-radius:10px; padding:8px 14px; }
        .wadah { max-width:1150px; margin:auto; padding:30px 20px 60px; }
        h1 { color:var(--gelap); font-size:26px; } h2 { color:var(--gelap); font-size:19px; margin-bottom:15px; }
        .sapa { font-size:14px; margin:2px 0 22px; }
        .notice { border-radius:12px; padding:12px 16px; margin-bottom:18px; background:#E3F4D8; color:#2E6B1A; }
        .errors { background:#FBE4E0; color:#8A211B; border-radius:12px; padding:12px 16px; margin-bottom:18px; }
        .ringkasan { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
        .kartu,.panel { background:var(--kartu); border-radius:16px; padding:18px 20px; }
        .angka { color:var(--gelap); font-size:27px; font-weight:700; } .label { font-size:13px; }
        .menipis .angka { color:var(--oranye); } .habis .angka { color:var(--merah); }
        .panel { margin-bottom:22px; }
        .grid-form { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }
        label { display:block; font-size:13px; font-weight:600; margin-bottom:5px; }
        input,select,textarea { width:100%; border:1px solid #C6A66D; border-radius:9px; background:#fffef4; padding:10px 12px; font:inherit; color:var(--gelap); }
        textarea { min-height:75px; resize:vertical; } .full { grid-column:1/-1; }
        .btn { display:inline-block; border:0; border-radius:9px; background:var(--coklat); color:white; padding:9px 14px; font:600 13px Poppins,sans-serif; cursor:pointer; text-decoration:none; }
        .btn.secondary { background:#76502F; } .btn.danger { background:var(--merah); } .btn.light { background:#E8D8AE; color:var(--gelap); }
        .actions { display:flex; gap:7px; flex-wrap:wrap; }
        .tabel-wrap { background:var(--kartu); border-radius:16px; padding:8px 18px; overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:850px; }
        th { text-align:left; font-size:12px; padding:13px 9px; border-bottom:2px solid var(--coklat); }
        td { padding:12px 9px; border-bottom:1px solid #E3D9A8; vertical-align:middle; font-size:13px; }
        .thumb { width:64px; height:58px; object-fit:cover; border-radius:8px; background:#eee4c6; }
        .badge { display:inline-block; border-radius:20px; padding:3px 10px; font-size:11px; color:white; }
        .aman { background:var(--hijau); } .badge.menipis { background:var(--oranye); } .badge.habis { background:var(--merah); }
        .inline-stok { display:flex; gap:5px; align-items:center; } .inline-stok input { width:78px; padding:7px; }
        .edit-form { display:none; background:#fff9df; } .edit-form.aktif { display:table-row; }
        .edit-form td { padding:18px; } .kecil { font-size:12px; }
        @media(max-width:800px) { .ringkasan { grid-template-columns:repeat(2,1fr); } .grid-form { grid-template-columns:1fr; } .full { grid-column:auto; } }
    </style>
</head>
<body>
<header class="bar">
    <a href="{{ route('admin.stok') }}" class="logo">SnackinAja <span>Admin</span></a>
    <a href="{{ route('dashboard') }}" class="tautan">Lihat Toko</a>
    <a href="{{ route('logout.konfirmasi') }}" class="tautan">Keluar</a>
</header>
<main class="wadah">
    <h1>Kelola Stok & Produk</h1>
    <p class="sapa">Halo, {{ auth()->user()->name }}. Kelola produk yang tersimpan di database.</p>

    @if(session('sukses')) <div class="notice" role="status">{{ session('sukses') }}</div> @endif
    @if($errors->any())
        <div class="errors"><strong>Periksa kembali input:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <section class="ringkasan">
        <div class="kartu"><div class="angka">{{ $jumlahProduk }}</div><div class="label">Jumlah produk</div></div>
        <div class="kartu"><div class="angka">{{ number_format($totalStok,0,',','.') }}</div><div class="label">Total stok</div></div>
        <div class="kartu menipis"><div class="angka">{{ $jumlahMenipis }}</div><div class="label">Stok menipis (≤ 5)</div></div>
        <div class="kartu habis"><div class="angka">{{ $jumlahHabis }}</div><div class="label">Stok habis</div></div>
    </section>

    <section class="panel">
        <h2>Tambah Produk</h2>
        <form method="POST" action="{{ route('admin.stok.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid-form">
                <div><label for="nama">Nama produk *</label><input id="nama" name="nama" value="{{ old('nama') }}" required maxlength="255"></div>
                <div><label for="kategori">Kategori *</label><select id="kategori" name="kategori" required><option value="snack" @selected(old('kategori')==='snack')>Makanan Ringan</option><option value="drink" @selected(old('kategori')==='drink')>Minuman</option></select></div>
                <div><label for="harga">Harga (Rp) *</label><input id="harga" name="harga" type="number" min="0" value="{{ old('harga',0) }}" required></div>
                <div><label for="stok">Jumlah stok *</label><input id="stok" name="stok" type="number" min="0" max="4294967295" value="{{ old('stok',0) }}" required></div>
                <div class="full"><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea></div>
                <div class="full"><label for="gambar">Gambar (JPG, PNG, WEBP; maks. 2 MB)</label><input id="gambar" name="gambar" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div>
                <div class="full"><button class="btn" type="submit">+ Tambah Produk</button></div>
            </div>
        </form>
    </section>

    <section class="tabel-wrap">
        <table>
            <thead><tr><th>Gambar</th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Stok</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($produk as $p)
                @php
                    $status = $p->stok === 0 ? 'habis' : ($p->stok <= 5 ? 'menipis' : 'aman');
                    $statusText = $p->stok === 0 ? 'Habis' : ($p->stok <= 5 ? 'Menipis' : 'Aman');
                @endphp
                <tr>
                    <td>
                        @if($p->gambar)<img class="thumb" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($p->gambar) }}" alt="Gambar {{ $p->nama }}">
                        @else <div class="thumb" style="display:grid;place-items:center">—</div>@endif
                    </td>
                    <td><strong>{{ $p->nama }}</strong><div class="kecil">ID {{ $p->id }}</div></td>
                    <td>{{ $p->kategori === 'snack' ? 'Makanan Ringan' : 'Minuman' }}</td>
                    <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                    <td><span class="badge {{ $status }}">{{ $statusText }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.stok.update', $p) }}" class="inline-stok">
                            @csrf @method('PUT')
                            <input aria-label="Stok {{ $p->nama }}" name="stok" type="number" min="0" max="4294967295" value="{{ $p->stok }}" required>
                            <input type="hidden" name="nama" value="{{ $p->nama }}">
                            <input type="hidden" name="kategori" value="{{ $p->kategori }}">
                            <input type="hidden" name="harga" value="{{ $p->harga }}">
                            <input type="hidden" name="deskripsi" value="{{ $p->deskripsi }}">
                            <button class="btn" type="submit">Simpan</button>
                        </form>
                    </td>
                    <td><div class="actions">
                        <button type="button" class="btn secondary" onclick="toggleEdit('edit-{{ $p->id }}')">Edit</button>
                        <form method="POST" action="{{ route('admin.stok.destroy', $p) }}" onsubmit="return confirm('Hapus produk {{ addslashes($p->nama) }}?')">
                            @csrf @method('DELETE')<button class="btn danger" type="submit">Hapus</button>
                        </form>
                    </div></td>
                </tr>
                <tr id="edit-{{ $p->id }}" class="edit-form">
                    <td colspan="7">
                        <h2>Edit: {{ $p->nama }}</h2>
                        <form method="POST" action="{{ route('admin.stok.update', $p) }}" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="grid-form">
                                <div><label>Nama produk *</label><input name="nama" value="{{ $p->nama }}" required maxlength="255"></div>
                                <div><label>Kategori *</label><select name="kategori" required><option value="snack" @selected($p->kategori==='snack')>Makanan Ringan</option><option value="drink" @selected($p->kategori==='drink')>Minuman</option></select></div>
                                <div><label>Harga (Rp) *</label><input name="harga" type="number" min="0" value="{{ $p->harga }}" required></div>
                                <div><label>Jumlah stok *</label><input name="stok" type="number" min="0" value="{{ $p->stok }}" required></div>
                                <div class="full"><label>Deskripsi</label><textarea name="deskripsi">{{ $p->deskripsi }}</textarea></div>
                                <div class="full"><label>Ganti gambar (kosongkan jika tidak diganti)</label><input name="gambar" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></div>
                                <div class="full actions"><button class="btn" type="submit">Simpan Perubahan</button><button class="btn light" type="button" onclick="toggleEdit('edit-{{ $p->id }}')">Batal</button></div>
                            </div>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;padding:28px">Belum ada produk di database. Tambahkan produk melalui formulir di atas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
</main>
<script>
function toggleEdit(id) {
    const row = document.getElementById(id);
    if (row) row.classList.toggle('aktif');
}
</script>
</body>
</html>
