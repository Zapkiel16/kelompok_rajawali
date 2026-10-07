<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Pemesan;
use App\Support\NomorHp;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct(private RateLimiter $limiter, private Pemesan $pemesan)
    {
    }

    private function pesan(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP tidak valid. Contoh: 0812-3456-7890.',
            'no_hp.unique' => 'Nomor HP ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ];
    }

    // Rapikan isian sebelum divalidasi: email huruf kecil, nomor HP disamakan formatnya.
    private function rapikan(Request $request): void
    {
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
            'no_hp' => NomorHp::normalisasi($request->input('no_hp')),
        ]);
    }

    // ---------- Masuk ----------

    public function formMasuk()
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return view('auth.masuk');
    }

    public function masuk(Request $request)
    {
        $data = $request->validate([
            'akun' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'akun.required' => 'Email atau nomor HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $akun = trim($data['akun']);
        $kunci = Str::lower($akun) . '|' . $request->ip();

        if ($this->limiter->tooManyAttempts($kunci, 5)) {
            $detik = $this->limiter->availableIn($kunci);

            return back()->withErrors(['akun' => "Terlalu banyak percobaan. Coba lagi dalam {$detik} detik."])->onlyInput('akun');
        }

        // Boleh masuk pakai email atau nomor HP
        $kolom = str_contains($akun, '@') ? 'email' : 'no_hp';
        $nilai = $kolom === 'email' ? Str::lower($akun) : NomorHp::normalisasi($akun);

        if (!auth()->attempt([$kolom => $nilai, 'password' => $data['password']])) {
            $this->limiter->hit($kunci, 60);

            return back()->withErrors(['akun' => 'Email/nomor HP atau password salah.'])->onlyInput('akun');
        }

        $this->limiter->clear($kunci);
        $request->session()->regenerate(); // keranjang di session tetap terbawa
        $this->pemesan->klaimPesananTamu(auth()->user());

        // Selalu balik ke dashboard menu utama
        return redirect('/');
    }

    // ---------- Daftar ----------

    public function formDaftar()
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return view('auth.daftar');
    }

    public function daftar(Request $request)
    {
        $this->rapikan($request);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'regex:/^08\d{8,12}$/', 'unique:users,no_hp'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $this->pesan());

        $user = User::create([
            'name' => trim($data['nama']),
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'password' => $data['password'], // di-hash otomatis oleh model
        ]);

        auth()->login($user);
        $request->session()->regenerate();
        $this->pemesan->klaimPesananTamu($user);

        // Selalu balik ke dashboard menu utama
        return redirect('/');
    }

    // ---------- Lupa & atur ulang password ----------

    public function formLupa()
    {
        return view('auth.lupa-password');
    }

    public function kirimLink(Request $request, PasswordBroker $broker)
    {
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);

        $data = $request->validate([
            'email' => ['required', 'email'],
        ], $this->pesan());

        $broker->sendResetLink(['email' => $data['email']]);

        // Jawaban sama baik emailnya terdaftar maupun tidak, supaya email orang lain tidak bisa ditebak
        return back()->with('status', 'Jika email itu terdaftar, link untuk atur ulang password sudah dikirim. Cek inbox kamu.');
    }

    public function formReset(Request $request, string $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function reset(Request $request, PasswordBroker $broker)
    {
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $this->pesan());

        $status = $broker->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => $password])->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        if ($status === PasswordBroker::PASSWORD_RESET) {
            return redirect()->route('masuk')->with('status', 'Password berhasil diubah. Silakan masuk.');
        }

        return back()->withErrors(['email' => 'Link reset tidak valid atau sudah kedaluwarsa. Minta link baru.'])->onlyInput('email');
    }

    // ---------- Masuk sebagai tamu ----------

    public function formTamu()
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return view('auth.tamu', ['tamu' => session('tamu')]);
    }

    public function simpanTamu(Request $request)
    {
        $this->rapikan($request);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['required', 'regex:/^08\d{8,12}$/'],
        ], $this->pesan());

        session(['tamu' => [
            'nama' => trim($data['nama']),
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
        ]]);

        // Selalu balik ke dashboard menu utama, bukan ke checkout
        return redirect('/');
    }
}