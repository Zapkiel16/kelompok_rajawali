<?php

use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function masukSebagaiTamu(): void
{
    test()->post('/tamu', [
        'nama' => 'Budi',
        'email' => 'budi@example.com',
        'no_hp' => '081234567890',
    ])->assertRedirect('/');
}

it('mengarahkan pengunjung baru ke halaman masuk tanpa pesan, dan detail dengan pesan', function () {
    $this->get('/')->assertRedirect(route('masuk'))->assertSessionMissing('pesan');
    $this->get('/detail/1')->assertRedirect(route('masuk'))->assertSessionHas('pesan');
    $this->get('/masuk')->assertOk();
});

it('menampilkan dashboard dengan link ke detail tiap produk', function () {
    masukSebagaiTamu();

    $this->get('/')
        ->assertOk()
        ->assertSee('href="'.route('product.detail', 1).'"', false)
        ->assertSee('Rp 16.000')
        ->assertSee('Budi');
});

it('mencari produk dari dashboard', function () {
    masukSebagaiTamu();

    $this->get('/?q=Drink 3')
        ->assertOk()
        ->assertSee('Drink 3')
        ->assertDontSee('Item 1');

    $this->get('/?q=tidak-ada')->assertOk()->assertSee('belum ada');
});

it('membuka halaman detail dan 404 untuk id yang tidak ada', function () {
    masukSebagaiTamu();

    $this->get('/detail/6')->assertOk()->assertSee('Drink 1')->assertSee('Rp 5.000');
    $this->get('/detail/999')->assertNotFound();
});

it('mengarahkan ke halaman masuk kalau belum login saat menambah ke keranjang', function () {
    $this->post('/menu/tambah', ['id' => 1, 'jumlah' => 2])->assertRedirect(route('masuk'));
});

it('tamu bisa menambah produk dengan jumlah, lalu checkout sampai pesanan tercatat', function () {
    masukSebagaiTamu();

    $this->from('/detail/1')
        ->post('/menu/tambah', ['id' => 1, 'jumlah' => 3])
        ->assertRedirect('/detail/1')
        ->assertSessionHas('sukses');

    $this->get('/detail/1')->assertSee('masuk keranjang');
    $this->get('/keranjang')->assertOk()->assertSee('Item 1');

    $this->post('/checkout', ['metode' => 'Cash'])->assertRedirect();

    $transaksi = Transaksi::first();
    expect($transaksi)->not->toBeNull()
        ->and($transaksi->total_harga)->toBe(48000) // 3 x 16.000
        ->and($transaksi->nama_pemesan)->toBe('Budi');

    $this->get('/pesanan')->assertOk();
});

it('menolak jumlah yang tidak valid', function () {
    masukSebagaiTamu();

    $this->post('/menu/tambah', ['id' => 1, 'jumlah' => 0])->assertSessionHasErrors('jumlah');
    $this->post('/menu/tambah', ['id' => 999])->assertNotFound();
});

it('daftar akun lalu nama muncul di dashboard dan detail dengan menu akun', function () {
    $this->post('/daftar', [
        'nama' => 'Siti',
        'email' => 'siti@example.com',
        'no_hp' => '081298765432',
        'password' => 'rahasia123',
        'password_confirmation' => 'rahasia123',
    ])->assertRedirect('/');

    $this->get('/')->assertSee('Siti')->assertSee('Pesanan Saya')->assertSee('Keluar');
    $this->get('/detail/2')->assertSee('Siti')->assertSee('Pesanan Saya');

    $this->post('/menu/tambah', ['id' => 2, 'jumlah' => 2])->assertSessionHas('sukses');
    $this->get('/')->assertSee('cart-number', false);
});

it('lihat semua hanya menampilkan satu kategori', function () {
    masukSebagaiTamu();

    $this->get('/?kategori=drink')
        ->assertOk()
        ->assertSee('Drink 1')
        ->assertDontSee('Item 1')
        ->assertSee('Semua produk');

    $this->get('/?kategori=snack')->assertOk()->assertSee('Item 1')->assertDontSee('Drink 1');

    // kategori asing diabaikan -> tampil semua
    $this->get('/?kategori=ngawur')->assertOk()->assertSee('Item 1')->assertSee('Drink 1');
});

it('banner punya 3 halaman', function () {
    masukSebagaiTamu();

    $html = $this->get('/')->getContent();
    expect(substr_count($html, 'class="banner-slide"'))->toBe(3);
});