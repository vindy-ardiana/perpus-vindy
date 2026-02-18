<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center">

    <!-- CONTAINER -->
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT (WELCOME + BOOK IMAGE) -->
        <div class="hidden md:flex flex-col items-center justify-center p-16
                    bg-gradient-to-br from-indigo-600 to-blue-600 text-white">

            <img
                src="https://cdn-icons-png.flaticon.com/512/29/29302.png"
                alt="Buku"
                class="w-40 mb-10 drop-shadow-lg">

            <h2 class="text-4xl font-bold mb-4">
                Welcome Back!
            </h2>

            <p class="text-indigo-100 text-center text-lg leading-relaxed max-w-sm">
                Masuk kembali ke sistem perpustakaan digital
                dan lanjutkan aktivitas membaca serta peminjaman buku.
            </p>
        </div>

        <!-- RIGHT (FORM LOGIN) -->
        <div class="p-16 flex flex-col justify-center">

            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Login
            </h1>

            <p class="text-gray-500 mb-12">
                Silakan masuk untuk melanjutkan
            </p>

            <form action="{{ route('loginProses') }}" method="post">
                @csrf

                <!-- EMAIL -->
                <div class="mb-10">
                    <label class="block text-gray-600 text-sm mb-2 ">
                        Email
                    </label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan email..."
                        class="w-full border-b-2 border-gray-300 py-3 focus:outline-none rounded-xl focus:border-indigo-600 transition">
                </div>

                @error('email')
                    <div class="text-red-500 text-sm mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <!-- PASSWORD -->
                <div class="mb-10">
                    <label class="block text-gray-600 text-sm mb-2">
                        Password
                    </label>
                    <input type="password" name="password" placeholder="Masukkan password..." class="w-full border-b-2 rounded-xl border-gray-300 py-3
                    focus:outline-none focus:border-indigo-600 transition">
                </div>

                @error('password')
                    <div class="text-red-500 text-sm mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full mt-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold
                           hover:bg-indigo-700 transition active:scale-95">
                    Login
                </button>
            </form>

        </div>
    </div>

    @include('sweetalert::alert')

</body>
</html>
