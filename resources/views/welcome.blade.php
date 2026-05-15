<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>IWK RW 04 - Sistem Transparansi Kas Iuran Warga</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-body: #ffffff;
            --text-main: #082f49;
            --text-muted: #64748b;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --primary-blue: #4f46e5;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden !important;
        }
        body.light-mode {
            --bg-body: #ffffff;
            --text-main: #000000;
            --text-muted: #1e293b;
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.35) 0%, transparent 60%),
                radial-gradient(at 100% 0%, rgba(29, 53, 87, 0.3) 0%, transparent 60%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.25) 0%, transparent 60%),
                radial-gradient(at 0% 100%, rgba(226, 232, 240, 1) 0%, transparent 60%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }
        body {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, #d0e1fd 0%, transparent 45%),
                radial-gradient(at 100% 0%, #e0f2fe 0%, transparent 45%),
                radial-gradient(at 50% 50%, #f1f5f9 0%, transparent 70%),
                radial-gradient(at 0% 100%, #cbd5e1 0%, transparent 45%),
                radial-gradient(at 100% 100%, #d0e1fd 0%, transparent 45%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
            color: #0f172a;
            overflow-x: hidden;
            transition: all 0.4s ease;
        }

        /* --- STYLES KHUSUS MODE GELAP (SOLID NAVY) --- */
        .dark-mode, .dark, 
        .dark body, .dark-mode body {
            background-color: #020617 !important;
            background-image: none !important;
            color: #f8fafc !important;
        }
        
        .dark .glow-element, .dark .hero-gradient::before {
            display: none !important;
        }

        .dark .bg-white, 
        .dark .guide-card, 
        .dark .guide-sub-card, 
        .dark .card,
        .dark section,
        .dark details.group {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            backdrop-filter: blur(12px);
        }

        .dark .glass {
            background: rgba(15, 23, 42, 0.8) !important;
        }

        .dark .hero-gradient h1 {
            background: linear-gradient(to bottom, #ffffff, #818cf8) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }

        /* Typography visibility in Dark Mode */
        .dark h1, .dark h2, .dark h3, .dark h4, .dark .nama-kampus, .dark summary {
            color: #ffffff !important;
        }

        .dark p, .dark span:not(.text-[#4f46e5]), .dark li {
            color: #e2e8f0 !important;
        }

        .dark .text-slate-600, .dark .text-slate-500, .dark .text-slate-400 {
            color: #94a3b8 !important;
        }
        
        .dark footer p { color: #94a3b8 !important; }

        .dark .feature-icon-pastel i, .dark .guide-icon-box i, .dark .icon-fitur i, .dark .icon-tim i {
            color: #818cf8 !important;
        }

        .dark .pastel-indigo, .dark .pastel-emerald, .dark .pastel-amber, .dark .guide-icon-box {
            background-color: rgba(129, 140, 248, 0.1) !important;
        }

        .dark .floating-pill-nav {
            background: rgba(2, 6, 23, 0.8) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .dark .floating-pill-nav span {
            color: #ffffff !important;
        }

        /* --- UI EFFECTS & UTILITIES --- */
        .vignette-image {
            -webkit-mask-image: radial-gradient(circle, black 65%, transparent 100%);
            mask-image: radial-gradient(circle, black 65%, transparent 100%);
            transition: all 0.5s ease;
        }
        .vignette-image:hover {
            transform: scale(1.02);
            -webkit-mask-image: radial-gradient(circle, black 80%, transparent 100%);
            mask-image: radial-gradient(circle, black 80%, transparent 100%);
        }

        .glow-element { display: none; }
        .dark .glow-element { display: block; }

        /* --- Hero Slider --- */
        .hero-slider-box {
            width: 100%; max-width: 450px; margin: 0 auto; overflow: hidden;
            border-radius: 3rem; position: relative; z-index: 20;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        .hero-slider-track {
            display: flex; width: calc(450px * 7);
            animation: hero-scroll 35s linear infinite;
        }
        .hero-slide { width: 450px; height: 300px; flex-shrink: 0; }
        .hero-slide img { width: 100%; height: 100%; object-fit: cover; }
        @keyframes hero-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-450px * 4)); }
        }

        .floating-pill-nav {
            position: fixed; top: 1rem; left: 50%; transform: translateX(-50%);
            width: 95%; max-width: 1200px; background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px); border-radius: 2rem; padding: 0.5rem 1rem;
            z-index: 1000; box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Guide Specifics */
        .guide-card {
            background: #ffffff;
            border-radius: 4rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.04);
            padding: 5rem;
            border: 1px solid #f8fafc;
        }
        .guide-sub-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 2.5rem;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }
        .guide-icon-box {
            background-color: #f1f5ff;
            color: #4f46e5;
            border-radius: 1.5rem;
            width: 4.5rem;
            height: 4.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .whatsapp-banner {
            background: #059669 !important;
            border-radius: 3rem;
            padding: 3.5rem;
            color: white;
            box-shadow: 0 20px 40px rgba(5, 150, 105, 0.15);
        }
        .guide-sub-header { color: #4f46e5 !important; font-weight: 800 !important; }

        /* Team Card */
        .team-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            border: 1px solid #f8fafc;
        }
        .team-card.expanded {
            transform: scale(1.1);
            box-shadow: 0 20px 50px rgba(79, 70, 229, 0.1);
            border-color: #4f46e5;
            z-index: 10;
            position: relative;
        }
        .dark .team-card {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            backdrop-filter: blur(12px);
        }

        @media (max-width: 768px) {
            h1 { font-size: 2.25rem !important; line-height: 1.2 !important; }
            section { padding: 3rem 1.5rem !important; }
            .guide-card { padding: 2rem; border-radius: 2rem; }
        }
    </style>
</head>
<body class="antialiased font-sans">
    <nav class="floating-pill-nav no-print">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-[#4f46e5] rounded-full flex items-center justify-center shadow-lg shrink-0">
                    <i class="fas fa-dollar-sign text-white text-sm md:text-base"></i>
                </div>
                <span class="text-base md:text-xl font-black tracking-tighter text-slate-900 truncate">IWK RW 04</span>
            </div>
            <div class="flex items-center gap-4 md:gap-6">
                <button id="theme-toggle" class="p-2 rounded-xl bg-slate-50 text-slate-600">
                    <i id="theme-toggle-dark-icon" class="fas fa-moon"></i>
                    <i id="theme-toggle-light-icon" class="fas fa-sun" style="display:none"></i>
                </button>
                @auth
                    <a href="{{ route(Auth::user()->role === 'RW' ? 'dashboard.rw' : 'dashboard.rt') }}" class="text-xs md:text-sm font-black text-slate-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-xs md:text-sm font-black text-slate-600 dark:text-slate-300 hover:text-[#4f46e5] transition">Log In</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#4f46e5] text-white rounded-xl font-black text-xs md:text-sm transition hover:scale-105 shadow-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-gradient min-h-screen flex items-center justify-center pt-24 px-4 relative">
        <div class="max-w-5xl w-full text-center z-10">
            <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-white border border-slate-100 text-[#4f46e5] text-sm font-bold shadow-sm dark:bg-slate-800 dark:border-white/10 dark:text-indigo-400">
                🚀 Digitalisasi Keuangan Desa 4.0
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-[#000000] dark:text-white mb-8 tracking-tight leading-tight">
                Transparansi Kas Iuran Warga <br class="hidden md:block">
                RW 04 Kalitanjung Timur
            </h1>
            <p class="text-xl text-[#4f46e5] mb-12 max-w-2xl mx-auto leading-relaxed font-bold">
                Membangun kepercayaan warga melalui digitalisasi laporan keuangan yang akurat, otomatis, dan dapat diakses kapan saja dari mana saja.
            </p>
            
            <div class="hero-slider-box vignette-image mb-10">
                <div class="hero-slider-track">
                    <div class="hero-slide"><img src="{{ url('img/slide1.jpeg') }}"></div>
                    <div class="hero-slide"><img src="{{ url('img/slide2.jpeg') }}"></div>
                    <div class="hero-slide"><img src="{{ url('img/slide3.jpeg') }}"></div>
                    <div class="hero-slide"><img src="{{ url('img/rw04_sign.jpeg') }}"></div>
                    <div class="hero-slide"><img src="{{ url('img/slide1.jpeg') }}"></div>
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-10 py-4 bg-[#4f46e5] text-white rounded-2xl font-black shadow-xl hover:scale-105 transition">Mulai Sekarang</a>
            </div>
        </div>
    </header>

    <section class="py-24 px-6 bg-white dark:bg-transparent">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black text-slate-900 dark:text-white mb-4">Fitur Utama Platform</h2>
                <p class="text-[#4f46e5] max-w-xl mx-auto text-lg font-bold">Dilengkapi dengan teknologi otomasi terdepan untuk memudahkan tugas Bendahara.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm transition hover:shadow-md">
                    <div class="feature-icon-pastel pastel-indigo icon-fitur"><i class="fas fa-dollar-sign text-2xl"></i></div>
                    <h3 class="text-2xl font-black mb-4 text-[#000000] dark:text-white">Pencatatan Otomatis</h3>
                    <p class="text-slate-600 dark:text-slate-400 font-bold">Sistem cerdas mendeteksi iuran <strong>IWK (Rp 3.000)</strong> & <strong>Andon (Rp 5.000)</strong> berdasarkan status warga.</p>
                </div>
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm transition hover:shadow-md">
                    <div class="feature-icon-pastel pastel-emerald icon-fitur"><i class="fas fa-chart-line text-2xl"></i></div>
                    <h3 class="text-2xl font-black mb-4 text-[#000000] dark:text-white">Monitoring Real-time</h3>
                    <p class="text-slate-600 dark:text-slate-400 font-bold">Pantau grafik tunggakan bulanan, aliran kas, dan saldo akhir tiap unit RT secara instan.</p>
                </div>
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm transition hover:shadow-md">
                    <div class="feature-icon-pastel pastel-amber icon-fitur"><i class="fas fa-desktop text-2xl"></i></div>
                    <h3 class="text-2xl font-black mb-4 text-[#000000] dark:text-white">Laporan Publik</h3>
                    <p class="text-slate-600 dark:text-slate-400 font-bold">Ekspor laporan keuangan format <strong>A3 (Landscape)</strong> untuk publikasi mading warga.</p>
                </div>
            </div>
        </div>
    </section>

    </section>


    <section class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-8 md:p-16 rounded-[3rem] text-center border border-slate-50 shadow-sm dark:bg-slate-900/50 dark:border-white/10">
                <h2 class="text-3xl md:text-5xl font-black mb-8 text-[#000000] dark:text-white">Mengapa Digitalisasi IWK?</h2>
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-4xl mx-auto leading-relaxed font-bold">
                    Sistem Iuran Warga (IWK) RW 04 Kalitanjung Timur dikembangkan untuk menggantikan pencatatan manual yang rentan kesalahan. 
                    Dengan digitalisasi, transparansi keuangan antara pengurus RT dan warga dapat terjaga, terutama dalam membedakan iuran warga Pribumi dan Andon secara akurat.
                </p>
            </div>
        </div>
    </section>

    <section id="faq" class="py-24 px-6 no-print">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-black text-center mb-12 text-[#000000] dark:text-white">Pertanyaan Sering Diajukan (FAQ)</h2>
            <div class="space-y-4">
                <details class="group bg-white p-8 rounded-2xl border border-slate-50 shadow-sm cursor-pointer overflow-hidden transition-all duration-300">
                    <summary class="flex justify-between items-center font-black text-lg list-none dark:text-white">
                        Apa perbedaan IWK dan Andon?
                        <span class="text-[#4f46e5] transition-transform duration-300 group-open:rotate-180"><i class="fas fa-chevron-down"></i></span>
                    </summary>
                    <div class="mt-6 pt-6 border-t border-slate-50 dark:border-white/10 text-slate-600 dark:text-slate-400 font-bold leading-relaxed">
                        IWK (Iuran Warga Kampung) sebesar Rp 3.000 adalah iuran sukarela bagi warga pribumi, sedangkan Andon sebesar Rp 5.000 adalah iuran bagi warga pendatang atau yang mengontrak.
                    </div>
                </details>
                <details class="group bg-white p-8 rounded-2xl border border-slate-50 shadow-sm cursor-pointer overflow-hidden transition-all duration-300">
                    <summary class="flex justify-between items-center font-black text-lg list-none dark:text-white">
                        Bagaimana jika terjadi salah input?
                        <span class="text-[#4f46e5] transition-transform duration-300 group-open:rotate-180"><i class="fas fa-chevron-down"></i></span>
                    </summary>
                    <div class="mt-6 pt-6 border-t border-slate-50 dark:border-white/10 text-slate-600 dark:text-slate-400 font-bold leading-relaxed">
                        Jangan khawatir, hanya akun Bendahara (Admin) yang memiliki otoritas untuk memperbaiki atau menghapus data transaksi demi menjaga integritas data.
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section id="panduan" class="py-24 px-6 no-print">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-indigo-50 dark:bg-slate-800 text-[#4f46e5] dark:text-indigo-400 font-black text-xs uppercase tracking-widest mb-6">
                    <i class="fas fa-book-open"></i> Pusat Bantuan
                </div>
                <h2 class="text-5xl font-black mb-6 text-[#000000] dark:text-white">Buku Panduan Pengguna</h2>
                <p class="text-xl text-[#4f46e5] dark:text-indigo-400 font-bold max-w-2xl mx-auto mb-10">Panduan lengkap untuk mempermudah tugas pengurus RW 04 Kalitanjung Timur.</p>
            </div>

            <div class="space-y-12">
                <div class="guide-card dark:bg-slate-900/50 dark:border-white/10">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="guide-icon-box"><i class="fas fa-user-shield text-3xl"></i></div>
                        <div>
                            <h3 class="text-3xl font-black text-[#000000] dark:text-white">Bagian 1: Panduan Menu & Akses (Bendahara RW)</h3>
                            <p class="text-[#4f46e5] dark:text-indigo-400 font-black text-xs uppercase tracking-widest mt-1">PUSAT KENDALI SISTEM & PENGATURAN UTAMA</p>
                        </div>
                    </div>
                    <div class="whatsapp-banner mb-12">
                        <div class="flex flex-col md:flex-row items-center gap-10">
                            <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center shrink-0 border border-white/30"><i class="fab fa-whatsapp text-5xl text-white"></i></div>
                            <div>
                                <h4 class="text-3xl font-black mb-2 tracking-tight">Ingatkan Warga Lewat WhatsApp</h4>
                                <p class="text-white font-bold text-lg leading-relaxed">Cukup klik tombol hijau bergambar WhatsApp di daftar tunggakan. Sistem akan otomatis mengirim pesan pengingat tagihan ke HP warga secara sopan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="guide-sub-card dark:bg-slate-800 dark:border-white/5">
                            <h4 class="text-[#4f46e5] font-black text-xl mb-4 uppercase">MANAJEMEN WARGA</h4>
                            <p class="text-[#000000] dark:text-white font-bold">Lakukan pendataan warga secara rutin untuk memudahkan identifikasi status pembayaran iuran harian.</p>
                        </div>
                        <div class="guide-sub-card dark:bg-slate-800 dark:border-white/5">
                            <h4 class="text-[#4f46e5] font-black text-xl mb-4 uppercase">CETAK LAPORAN</h4>
                            <p class="text-[#000000] dark:text-white font-bold">Gunakan fitur cetak di akhir bulan sebagai bukti pertanggungjawaban fisik bagi lingkungan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-slate-900/50 p-12 rounded-[4rem] border border-slate-50 dark:border-white/10 shadow-sm text-center">
                <h2 class="text-3xl font-black text-[#000000] dark:text-white mb-12 tracking-tight">Cakupan Wilayah RW 04</h2>
                <div class="flex flex-wrap justify-center gap-16">
                    <div class="text-center group">
                        <div class="text-4xl font-black text-[#4f46e5] mb-2">RT 01</div>
                        <span class="text-slate-400 text-xs uppercase tracking-widest font-black">Sektor Timur</span>
                    </div>
                    <div class="w-px h-16 bg-slate-100 dark:bg-white/10 hidden md:block"></div>
                    <div class="text-center group">
                        <div class="text-4xl font-black text-[#4f46e5] mb-2">RT 02</div>
                        <span class="text-slate-400 text-xs uppercase tracking-widest font-black">Sektor Tengah</span>
                    </div>
                    <div class="w-px h-16 bg-slate-100 dark:bg-white/10 hidden md:block"></div>
                    <div class="text-center group">
                        <div class="text-4xl font-black text-[#4f46e5] mb-2">RT 03</div>
                        <span class="text-slate-400 text-xs uppercase tracking-widest font-black">Sektor Barat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Credit Scene / Meet Our Team Section -->
    <section id="meet-the-team" class="py-24 px-6 relative overflow-hidden tim-pengembang">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black mb-6 text-[#000000] dark:text-white tracking-tight">
                    Struktur Organisasi RW 04 Kalitanjung Timur
                </h2>
                <div class="h-1.5 w-32 bg-[#4f46e5] mx-auto rounded-full"></div>
            </div>

            <!-- BARIS 1: RW -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="team-card text-center" onclick="this.classList.toggle('expanded')">
                    <div class="w-16 h-16 bg-indigo-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-8 text-[#4f46e5] dark:text-indigo-400">
                        <i class="fas fa-user-tie text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-[#000000] dark:text-white">Toto S</h3>
                    <p class="text-xs font-black tracking-widest uppercase text-slate-400">Ketua RW 04</p>
                </div>
                <div class="team-card text-center" onclick="this.classList.toggle('expanded')">
                    <div class="w-16 h-16 bg-indigo-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-8 text-[#4f46e5] dark:text-indigo-400">
                        <i class="fas fa-file-alt text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-[#000000] dark:text-white">Benyamin Ahmad</h3>
                    <p class="text-xs font-black tracking-widest uppercase text-slate-400">Sekretaris</p>
                </div>
                <div class="team-card text-center" onclick="this.classList.toggle('expanded')">
                    <div class="w-16 h-16 bg-indigo-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-8 text-[#4f46e5] dark:text-indigo-400">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-[#000000] dark:text-white">Asrimawati</h3>
                    <p class="text-xs font-black tracking-widest uppercase text-slate-400">Bendahara RW</p>
                </div>
            </div>

            <!-- BARIS 2: SELURUH RT -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- RT 01 -->
                <div class="team-card p-6 rounded-3xl" onclick="this.classList.toggle('expanded')">
                    <div class="text-center mb-6">
                        <span class="px-4 py-1.5 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full text-[10px] font-black text-indigo-500 dark:text-indigo-300 uppercase tracking-widest">Wilayah RT 01</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#4f46e5] dark:text-indigo-400 shadow-sm border border-slate-50 dark:border-white/5">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#000000] dark:text-white">Yayat Nurhayat</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Ketua</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#4f46e5] dark:text-indigo-400 shadow-sm border border-slate-50 dark:border-white/5">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#000000] dark:text-white">Bambang</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RT 02 -->
                <div class="team-card p-6 rounded-3xl" onclick="this.classList.toggle('expanded')">
                    <div class="text-center mb-6">
                        <span class="px-4 py-1.5 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full text-[10px] font-black text-indigo-500 dark:text-indigo-300 uppercase tracking-widest">Wilayah RT 02</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#4f46e5] dark:text-indigo-400 shadow-sm border border-slate-50 dark:border-white/5">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#000000] dark:text-white">Yuyun Yuningsih</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Ketua</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#4f46e5] dark:text-indigo-400 shadow-sm border border-slate-50 dark:border-white/5">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#000000] dark:text-white">Nokmala</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RT 03 -->
                <div class="team-card p-6 rounded-3xl" onclick="this.classList.toggle('expanded')">
                    <div class="text-center mb-6">
                        <span class="px-4 py-1.5 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full text-[10px] font-black text-indigo-500 dark:text-indigo-300 uppercase tracking-widest">Wilayah RT 03</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#4f46e5] dark:text-indigo-400 shadow-sm border border-slate-50 dark:border-white/5">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#000000] dark:text-white">Cici Surahman</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Ketua</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center text-[#4f46e5] dark:text-indigo-400 shadow-sm border border-slate-50 dark:border-white/5">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-[#000000] dark:text-white">Sri Mufarida</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LOGO KAMPUS -->
            <div class="mt-20 flex flex-col items-center gap-12 text-center">
                <a href="https://pmb.ikmi.ac.id/" target="_blank" class="group hover:scale-105 transition flex flex-col items-center gap-6">
                    <img src="{{ url('img/logo_ikmi.png') }}" alt="Logo STMIK IKMI Cirebon" class="w-32 md:w-48 h-auto drop-shadow-xl">
                    <h4 class="text-2xl md:text-4xl font-black tracking-[0.2em] text-[#000000] dark:text-white uppercase">
                        STMIK IKMI CIREBON
                    </h4>
                </a>
            </div>
        </div>
    </section>

    <footer class="mt-24 pt-16 pb-12 border-t border-white/5 bg-[#020617] text-white no-print">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
            <div>
                <h4 class="text-base font-black text-white uppercase mb-4">IWK RW 04 Kalitanjung Timur</h4>
                <p class="text-xs text-slate-300 font-medium mb-4">Sistem Informasi Manajemen Keuangan dan Administrasi Warga berbasis Digital.</p>
                <div class="space-y-3 mt-6">
                    <a href="https://wa.me/6282217655164" target="_blank" class="flex items-center justify-center md:justify-start gap-3 text-xs text-slate-300 hover:text-indigo-400 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                            <i class="fab fa-whatsapp text-indigo-400"></i>
                        </div>
                        <span class="font-medium">082217655164</span>
                    </a>
                    <a href="mailto:rw04kalitanjungtimur@gmail.com" class="flex items-center justify-center md:justify-start gap-3 text-xs text-slate-300 hover:text-indigo-400 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                            <i class="far fa-envelope text-indigo-400"></i>
                        </div>
                        <span class="font-medium">rw04kalitanjungtimur@gmail.com</span>
                    </a>
                </div>
            </div>
            <div>
                <h5 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-4">Sekretariat & Wilayah</h5>
                <div class="space-y-4">
                    <a href="https://maps.app.goo.gl/guv87yfmG1Zcz1Tw5?g_st=aw" target="_blank" class="flex items-start justify-center md:justify-start gap-3 text-xs text-slate-300 group hover:text-indigo-400 transition-all">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-500/20 transition-colors">
                            <i class="fas fa-map-marker-alt text-indigo-400"></i>
                        </div>
                        <p class="font-medium leading-relaxed">RW 04 Kalitanjung Timur, Harjamukti, Kota Cirebon.</p>
                    </a>
                    <div class="flex items-start justify-center md:justify-start gap-3 text-xs text-slate-300">
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-indigo-400"></i>
                        </div>
                        <p class="font-medium leading-relaxed italic">Melayani RT 01, RT 02, dan RT 03.</p>
                    </div>
                </div>
            </div>
            <div>
                <h5 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-4">Informasi Sistem</h5>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">
                    Dikembangkan oleh: <br>
                    <a href="{{ route('tentang.kami') }}" class="underline text-indigo-300 hover:text-white transition font-black tracking-wide">
                        MAHASISWA SISTEM INFORMASI - STMIK IKMI CIREBON
                    </a>
                </p>
                <div class="mt-8 flex items-center justify-center md:justify-start gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest">© 2026 Hak Cipta Terpelihara.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        function setTheme(theme) {
            if (theme === 'light') {
                document.body.classList.add('light-mode');
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            } else {
                document.body.classList.remove('light-mode');
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            }
            localStorage.setItem('theme', theme);
        }
        themeToggleBtn.addEventListener('click', () => {
            setTheme(document.body.classList.contains('light-mode') ? 'dark' : 'light');
        });
        setTheme(localStorage.getItem('theme') || 'dark');
    </script>
</body>
</html>