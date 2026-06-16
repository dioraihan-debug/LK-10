<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Secure dio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen font-sans relative selection:bg-indigo-600 selection:text-white">

    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl pointer-events-none"></div>

    <header class="border-b border-slate-200 bg-white/85 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50 animate-pulse"></span>
                <span class="font-extrabold tracking-wider text-lg bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Kabel Kusut</span>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-600 hidden sm:inline">Halo, <strong class="text-slate-800">{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 hover:border-rose-600 rounded-lg transition-all duration-300 shadow-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Konten Utama (Welcome, Form Masukan, API Endpoint) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Welcome Banner Card -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                    <div class="absolute right-0 bottom-0 opacity-15 transform translate-x-6 translate-y-6">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                    </div>
                    <div class="relative z-10 space-y-2">
                        <h1 class="text-2xl font-extrabold tracking-tight">Selamat Datang di Kabel Kusut! 👋</h1>
                        <p class="text-sm text-indigo-100 max-w-xl">
                            Sistem autentikasi aman dengan integrasi SSO WorkOS AuthKit. Anda saat ini login sebagai <strong>{{ Auth::user()->name }}</strong>. Semua lalu lintas data terenkripsi dan terlindungi.
                        </p>
                    </div>
                </div>

                <!-- Formulir Masukan Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Formulir Masukan (Validasi & Sanitasi)</h2>
                        <p class="text-sm text-slate-500 mt-1">Mengilustrasikan pengamanan input dari serangan XSS dan SQLi secara langsung.</p>
                    </div>

                    @if (session('success_feedback'))
                        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl font-medium">
                            {{ session('success_feedback') }}
                        </div>
                    @endif

                    <form action="{{ route('dashboard.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1" for="name">Nama (min: 3, max: 50)</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name) }}"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:border-indigo-600 focus:bg-white text-sm transition-all @error('name') border-rose-500 focus:border-rose-500 @enderror">
                                @error('name')
                                    <span class="text-rose-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1" for="email">Alamat Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:border-indigo-600 focus:bg-white text-sm transition-all @error('email') border-rose-500 focus:border-rose-500 @enderror">
                                @error('email')
                                    <span class="text-rose-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1" for="feedback">Pesan Feedback</label>
                            <textarea id="feedback" name="feedback" rows="4" placeholder="Tuliskan feedback Anda disini..."
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-800 rounded-xl focus:outline-none focus:border-indigo-600 focus:bg-white text-sm transition-all @error('feedback') border-rose-500 focus:border-rose-500 @enderror">{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <span class="text-rose-600 text-xs mt-1 block font-medium">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="py-2.5 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition-all duration-300 shadow-sm hover:shadow-indigo-100">
                            Kirim Feedback Secara Aman
                        </button>
                    </form>
                </div>

                <!-- Integrasi Endpoint API Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Integrasi Endpoint API (JSON)</h2>
                            <p class="text-sm text-slate-500">Endpoint terproteksi di <code class="text-indigo-600 font-semibold bg-indigo-50 px-1.5 py-0.5 rounded">/api/user</code> yang mengembalikan data JSON profil.</p>
                        </div>
                        <button id="btn-fetch-api" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold transition-all shadow-sm">
                            Ambil Data API
                        </button>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 relative">
                        <span class="absolute right-3 top-3 text-[10px] uppercase font-mono tracking-widest text-slate-400">Response</span>
                        <pre id="api-output" class="text-xs font-mono text-emerald-600 overflow-x-auto min-h-[40px] flex items-center">Menunggu aksi Anda... Klik tombol "Ambil Data API" di atas.</pre>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Sidebar (Profil Sesi & Metrik Status) -->
            <div class="space-y-8">
                
                <!-- Informasi Sesi Pengguna Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Sesi
                    </h2>
                    <div class="space-y-4 text-sm">
                        <div class="pb-3 border-b border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase tracking-wider font-semibold">Nama Lengkap</span>
                            <span class="font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="pb-3 border-b border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase tracking-wider font-semibold">Email Terdaftar</span>
                            <span class="font-semibold text-slate-700">{{ Auth::user()->email }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block uppercase tracking-wider font-semibold">ID Pengguna (WorkOS)</span>
                            <span class="font-mono text-xs text-slate-600 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded inline-block mt-1.5 break-all">{{ Auth::id() }}</span>
                        </div>
                    </div>
                </div>

                <!-- System Metrics Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="text-md font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-4.5 h-4.5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Keamanan & Metrik
                    </h2>
                    <div class="space-y-3.5 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Proteksi XSS & SQLi</span>
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-full border border-emerald-100">Aktif</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Token CSRF</span>
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-full border border-emerald-100">Tervalidasi</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Provider SSO</span>
                            <span class="text-slate-700 font-semibold">WorkOS AuthKit</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Platform</span>
                            <span class="text-slate-700 font-semibold">Laravel 12 + Tailwind v4</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-slate-200 text-center text-xs text-slate-500">
        &copy; 2026 Aplikasi Secure Terproteksi - Dibuat khusus untuk dio
    </footer>

</body>
</html>
