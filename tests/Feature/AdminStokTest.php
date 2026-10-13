<?php

use App\Data\ProductCatalog;
use App\Models\StokProduk;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function buatAdmin(array $atribut = []): User
{
    return User::factory()->admin()->create($atribut);
}

it('mengarahkan pengunjung yang belum login ke halaman masuk', function () {
    $this->get('/admin/stok')->assertRedirect(route('masuk'))->assertSessionHas('pesan');
    $this->post('/admin/stok/1', ['stok' => 5])->assertRedirect(route('masuk'));
});

it('mengarahkan tamu ke halaman masuk karena tamu bukan admin', function () {
    $this->post('/tamu', ['nama' => 'Budi', 'email' => 'budi@example.com', 'no_hp' => '081234567890']);

    $this->get('/admin/stok')->assertRedirect(route('masuk'));
});

it('menolak akun biasa dengan 403, baik membuka maupun mengubah stok', function () {
    $pembeli = User::factory()->create();

    $this->actingAs($pembeli)->get('/admin/stok')->assertForbidden();
    $this->actingAs($pembeli)->post('/admin/stok/1', ['stok' => 5])->assertForbidden();

    $this->assertDatabaseCount('stok_produks', 0);
});

it('menampilkan stok semua produk untuk admin', function () {
    $this->actingAs(buatAdmin(['name' => 'Bu Admin']))
        ->get('/admin/stok')
        ->assertOk()
        ->assertSee('Kelola Stok')
        ->assertSee('Bu Admin')
        ->assertSee('Item 1')
        ->assertSee('Drink 5')
        ->assertViewHas('jumlahProduk', 10)
        ->assertViewHas('totalStok', 10 * ProductCatalog::STOK_AWAL)
        ->assertViewHas('jumlahMenipis', 0)
        ->assertViewHas('jumlahHabis', 0);
});

it('menghitung stok menipis dan habis di ringkasan', function () {
    StokProduk::factory()->create(['produk_id' => 1, 'stok' => 0]);
    StokProduk::factory()->create(['produk_id' => 2, 'stok' => 3]);

    $this->actingAs(buatAdmin())
        ->get('/admin/stok')
        ->assertOk()
        ->assertViewHas('jumlahHabis', 1)
        ->assertViewHas('jumlahMenipis', 1)
        ->assertViewHas('totalStok', 3 + 8 * ProductCatalog::STOK_AWAL);
});

it('memakai stok awal untuk produk yang belum pernah diatur', function () {
    expect(ProductCatalog::find(1)['stock'])->toBe(ProductCatalog::STOK_AWAL);
});

it('admin bisa mengubah stok, dan perubahan terlihat di halaman detail', function () {
    $admin = buatAdmin();

    $this->actingAs($admin)
        ->post('/admin/stok/1', ['stok' => 0])
        ->assertRedirect(route('admin.stok'))
        ->assertSessionHas('sukses');

    $this->assertDatabaseHas('stok_produks', ['produk_id' => 1, 'stok' => 0]);
    $this->actingAs($admin)->get('/detail/1')->assertOk()->assertSee('Stok Kosong');

    // Mengubah lagi memperbarui baris yang sama, bukan menambah baris baru
    $this->actingAs($admin)->post('/admin/stok/1', ['stok' => 12]);

    $this->assertDatabaseCount('stok_produks', 1);
    expect(ProductCatalog::find(1)['stock'])->toBe(12);
    $this->actingAs($admin)->get('/detail/1')->assertOk()->assertDontSee('Stok Kosong');
});

it('menolak stok yang tidak valid dan tidak mengubah apa pun', function (mixed $nilai) {
    $this->actingAs(buatAdmin())
        ->from('/admin/stok')
        ->post('/admin/stok/1', ['stok' => $nilai])
        ->assertRedirect('/admin/stok')
        ->assertSessionHasErrorsIn('stok-1', 'stok');

    $this->assertDatabaseCount('stok_produks', 0);
})->with([
    'kosong' => [''],
    'negatif' => [-1],
    'bukan angka' => ['banyak'],
    'pecahan' => [2.5],
    'terlalu besar' => [10000],
]);

it('memberi 404 kalau produk tidak ada', function () {
    $this->actingAs(buatAdmin())->post('/admin/stok/999', ['stok' => 5])->assertNotFound();
});

it('mengarahkan admin ke halaman stok setelah masuk', function () {
    buatAdmin(['email' => 'admin@example.com']);

    $this->post('/masuk', ['akun' => 'admin@example.com', 'password' => 'password'])
        ->assertRedirect(route('admin.stok'));
});

it('tetap mengarahkan akun biasa ke dashboard setelah masuk', function () {
    User::factory()->create(['email' => 'budi@example.com']);

    $this->post('/masuk', ['akun' => 'budi@example.com', 'password' => 'password'])
        ->assertRedirect('/');
});

it('menampilkan link Kelola Stok hanya untuk admin', function () {
    $this->actingAs(buatAdmin())->get('/')->assertOk()->assertSee('Kelola Stok');
    $this->actingAs(buatAdmin())->get('/pesanan')->assertOk()->assertSee('Kelola Stok');

    $this->actingAs(User::factory()->create())->get('/')->assertOk()->assertDontSee('Kelola Stok');
});

it('tidak bisa mendaftar sebagai admin lewat form pendaftaran', function () {
    $this->post('/daftar', [
        'nama' => 'Budi',
        'email' => 'budi@example.com',
        'no_hp' => '081234567890',
        'password' => 'rahasia123',
        'password_confirmation' => 'rahasia123',
        'is_admin' => 1,
    ])->assertRedirect('/');

    expect(User::where('email', 'budi@example.com')->first()->adalahAdmin())->toBeFalse();
});

it('seeder membuat akun admin dari config dan aman dijalankan berulang', function () {
    config(['admin.email' => 'owner@snackinaja.test', 'admin.password' => 'kata-sandi-kuat']);

    $this->seed(AdminSeeder::class);
    $this->seed(AdminSeeder::class);

    expect(User::where('email', 'owner@snackinaja.test')->count())->toBe(1);

    $this->post('/masuk', ['akun' => 'owner@snackinaja.test', 'password' => 'kata-sandi-kuat'])
        ->assertRedirect(route('admin.stok'));
});
