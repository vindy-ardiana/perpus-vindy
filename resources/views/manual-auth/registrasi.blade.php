<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register Perpustakaan</title>
  @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-100">

  <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 items-stretch">

    <!-- LEFT IMAGE (BOOKS) -->
    <div class="relative hidden md:block h-[520px]">
      <img
        src="{{ asset('img/download.jpg') }}"
        alt="library books"
        class="w-full h-full object-cover rounded-l-3xl"
      />

      <!-- overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent rounded-l-3xl"></div>

      <div class="absolute bottom-10 left-10 right-10 text-white">
        <h2 class="text-3xl font-bold mb-3">Perpustakaan Digital</h2>
        <p class="text-sm opacity-90 leading-relaxed">
          Akses ribuan koleksi buku, literatur, dan pengetahuan  
          dalam satu sistem modern 📖
        </p>
      </div>
    </div>

    <!-- RIGHT FORM -->
    <div class="flex items-center justify-center px-10 py-12">
      <div class="w-full max-w-sm">

        <h1 class="text-3xl font-bold text-blue-800 mb-2">Registrasi Anggota</h1>
        <p class="text-sm text-blue-600 mb-8">Daftarkan diri Anda untuk mengakses perpustakaan</p>

        <form action="{{ route('registrasiProses') }}" method="post">
          @csrf

          <!-- Nama -->
          <div class="mb-4">
            <label class="text-xs uppercase tracking-wider text-blue-600">Nama Lengkap</label>
            <input
              type="text"
              name="nama"
              placeholder="Nama lengkap"
              class="mt-2 w-full px-4 py-3 rounded-xl bg-blue-50 border border-blue-200
              focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
              required
            />
          </div>

          <!-- Email -->
          <div class="mb-4">
            <label class="text-xs uppercase tracking-wider text-blue-600">Email</label>
            <input
              type="email"
              name="email"
              placeholder="email@example.com"
              class="mt-2 w-full px-4 py-3 rounded-xl bg-blue-50 border border-blue-200
              focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
              required
            />
          </div>

          <!-- Password -->
          <div class="mb-6">
            <label class="text-xs uppercase tracking-wider text-blue-600">Password</label>
            <input
              type="password"
              name="password"
              placeholder="••••••••"
              class="mt-2 w-full px-4 py-3 rounded-xl bg-blue-50 border border-blue-200
              focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
              required
              minlength="6"
            />
          </div>

          <button
            type="submit"
            class="w-full py-3 rounded-xl font-semibold text-white
            bg-gradient-to-r from-blue-700 to-blue-900
            hover:from-blue-800 hover:to-blue-950
            shadow-lg hover:shadow-xl transition"
          >
            Daftar Anggota
          </button>

          <p class="text-xs text-center text-blue-400 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-700 font-medium hover:underline">Login</a>
          </p>
        </form>
      </div>
    </div>

  </div>
</body>
</html>
