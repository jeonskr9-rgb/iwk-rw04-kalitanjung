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
    <?php array_map('unlink', glob(storage_path('framework/views/*.php'))); ?>
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
        }
        body.light-mode {
            --bg-body: #ffffff;
            --text-main: #000000;
            --text-muted: #1e293b;
            /* Extra Thick & Vibrant Cloud Gradient */
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

        /* --- STYLES KHUSUS MODE GELAP (SCOPED) --- */
        .dark-mode, .dark {
            background-color: #020617 !important;
            background-image: none !important;
        }
        
        .dark-mode .hero-gradient, .dark .hero-gradient {
            background: transparent;
            position: relative;
            z-index: 10;
        }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.5);
        }
        body:not(.light-mode) .glass {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glow-button {
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.3);
            transition: all 0.3s ease;
        }
        .glow-button:hover {
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            transform: translateY(-1px);
        }
        .bg-royal-blue {
            background-color: #4f46e5 !important;
            color: white !important;
        }
        .bg-royal-blue:hover {
            background-color: #4338ca !important;
        }
        .btn-white-outline {
            background-color: white !important;
            color: #0d1b2a !important;
            border: 1px solid #e2e8f0 !important;
        }
        .btn-white-outline:hover {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
        }

        .guide-card {
            background: #ffffff !important;
            border-radius: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.04);
            padding: 2rem;
            border: 1px solid #f8fafc;
        }
        @media (min-width: 768px) {
            .guide-card { border-radius: 4rem; padding: 5rem; }
        }
        .guide-sub-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 1.5rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        @media (min-width: 768px) {
            .guide-sub-card { border-radius: 2.5rem; padding: 2.5rem; }
        }
        .guide-icon-box {
            background-color: #f1f5ff;
            color: #4f46e5;
            border-radius: 1rem;
            width: 3.5rem;
            height: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        @media (min-width: 768px) {
            .guide-icon-box { border-radius: 1.5rem; width: 4.5rem; height: 4.5rem; }
        }
        .whatsapp-banner {
            background: #059669 !important;
            border-radius: 2rem;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 20px 40px rgba(5, 150, 105, 0.15);
        }
        @media (min-width: 768px) {
            .whatsapp-banner { border-radius: 3rem; padding: 3.5rem; }
        }
        .guide-sub-header { color: #4f46e5 !important; font-weight: 800 !important; }
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
        }
        .feature-icon-pastel {
            width: 4rem;
            height: 4rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        .pastel-indigo { background-color: #eef2ff; color: #4f46e5; }
        .pastel-emerald { background-color: #ecfdf5; color: #10b981; }
        .pastel-amber { background-color: #fffbeb; color: #f59e0b; }
        
        .floating-pill-nav {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            z-index: 1000;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        @media (min-width: 768px) {
            .floating-pill-nav { top: 1.5rem; width: 90%; border-radius: 2.5rem; padding: 0.85rem 2.5rem; }
        }
        
        details summary::-webkit-details-marker {
            display: none;
        }
        
        #theme-toggle { transition: all 0.3s ease; }
        body.light-mode #theme-toggle { color: #082f49 !important; background: #f1f5f9 !important; }
        
        /* Print Optimization */
        @media print {
            html, body {
                height: auto !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print, nav, footer, #theme-toggle, .hero-gradient, section, #meet-the-team, #faq { 
                display: none !important; 
            }
            #formal-print-guide {
                display: block !important;
                color: black !important;
                padding: 20mm !important;
                background: white !important;
            }
        }

        /* OPTIMASI MOBILE (Media Queries) */
        @media (max-width: 768px) {
            /* 1. Padding & Margin diperkecil */
            section { padding-top: 3rem !important; padding-bottom: 3rem !important; padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
            .hero-gradient { padding-left: 1.5rem !important; padding-right: 1.5rem !important; }
            
            /* 2. Ukuran Teks (H1 & H2) lebih proporsional */
            h1 { font-size: 2.25rem !important; line-height: 1.2 !important; }
            h2 { font-size: 1.75rem !important; }
            
            /* 3. Fallback Glassmorphism (Solid Color agar tidak lag di HP jadul) */
            .floating-pill-nav, .dashboard-footer, .glass {
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
                background: rgba(15, 23, 42, 0.95) !important;
            }
            .light-mode .floating-pill-nav, .light-mode .dashboard-footer {
                background: rgba(255, 255, 255, 0.98) !important;
            }

            /* 4. Memaksa tim pengembang menjadi 1 kolom vertikal */
            .tim-pengembang .grid { 
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important; 
            }
        }
        /* --- STYLES KHUSUS MODE GELAP (FINAL PREMIUM SCOPED) --- */
        .dark-mode, .dark {
            background-color: #020617 !important;
            background-image: none !important;
        }
        
        .dark-mode .hero-gradient, .dark .hero-gradient {
            background: transparent;
            position: relative;
            z-index: 10;
        }

        /* 1. Luxurious Glassmorphism for All Boxes */
        .dark-mode .card, 
        .dark-mode .bg-white, 
        .dark-mode [class*="bg-white/"],
        .dark .card,
        .dark .bg-white,
        .dark .guide-card,
        .dark .guide-sub-card,
        .dark .team-card,
        .dark section .bg-white,
        .dark #faq details {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(12px) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3) !important;
            color: #ffffff !important;
        }

        /* 2. Typography & Contrast (Anti-Tenggelam) */
        .dark-mode h1, .dark-mode h2, .dark-mode h3, .dark-mode h4,
        .dark h1, .dark h2, .dark h3, .dark h4,
        .dark .tim-pengembang h2, .dark .nama-kampus {
            color: #ffffff !important; /* Pure White for Titles & Institutions */
        }
        
        .dark-mode .sub-judul-utama, .dark .sub-judul-utama,
        .dark .text-[#4f46e5], .dark .text-indigo-600 {
            color: #93c5fd !important; /* Bright Blue/Cyan for Sub-titles */
        }
        
        .dark-mode p, .dark p, 
        .dark .text-slate-600, .dark .text-slate-500, .dark .text-slate-400,
        .dark .guide-card p, .dark .guide-sub-card p,
        .dark .card p, .dark .card span {
            color: #e2e8f0 !important; /* Soft White/Grey for Content */
        }

        /* 3. Icon Brilliance (Indigo Glow) */
        .dark-mode .icon-fitur, .dark-mode .icon-tim, .dark .icon-fitur, .dark .icon-tim,
        .dark .feature-icon-pastel i, .dark .guide-icon-box i, .dark .fa-location-dot,
        .dark .fas, .dark .fab, .dark .fa-solid {
            color: #818cf8 !important; /* Indigo Glow */
        }
        
        .dark .pastel-indigo, .dark .pastel-emerald, .dark .pastel-amber,
        .dark .bg-indigo-50, .dark .bg-emerald-50, .dark .bg-amber-50,
        .dark .guide-icon-box {
            background-color: rgba(129, 140, 248, 0.1) !important;
        }

        /* 4. Navbar & Footer Fixes */
        .dark .floating-pill-nav {
            background: rgba(2, 6, 23, 0.8) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark .floating-pill-nav span.text-slate-900 {
            color: #ffffff !important; /* Brand Logo 'IWK RW 04' White */
        }
        .dark footer p { color: #94a3b8 !important; }
        
        .dark .whatsapp-banner i.fab.fa-whatsapp {
            color: #ffffff !important; /* WhatsApp Icon White */
        }

        .dark-mode .hero-gradient h1, .dark .hero-gradient h1 {
            background: linear-gradient(to bottom, #ffffff, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Glow Visibility */
        .glow-element { display: none; }
        .dark-mode .glow-element, .dark .glow-element { display: block; }
    </style>
</head>
<body class="antialiased font-sans">
    <!-- Decorative Glows (Sembunyikan di Mode Terang) -->
    <div class="glow-element absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-blue-500/20 rounded-full blur-[150px] pointer-events-none animate-pulse z-0"></div>
    <div class="glow-element absolute -top-24 -left-24 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="glow-element absolute -bottom-24 -right-24 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'light') { document.body.classList.add('light-mode'); }
        })();
    </script>

    <nav class="floating-pill-nav no-print">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 md:gap-3">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-[#4f46e5] rounded-full flex items-center justify-center shadow-lg shrink-0">
                    <i class="fas fa-dollar-sign text-white text-sm md:text-base"></i>
                </div>
                <span class="text-base md:text-xl font-black tracking-tighter text-slate-900 truncate max-w-[100px] md:max-w-none">IWK RW 04</span>
            </div>
            
            <div class="flex items-center gap-2 md:gap-6">
                <button id="theme-toggle" class="p-2 rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-100 transition shadow-sm">
                    <i id="theme-toggle-dark-icon" class="fas fa-moon text-sm md:text-base" style="display: block;"></i>
                    <i id="theme-toggle-light-icon" class="fas fa-sun text-sm md:text-base" style="display: none;"></i>
                </button>
                
                @auth
                    @php $dashboardRoute = Auth::user()->role === 'RW' ? 'dashboard.rw' : 'dashboard.rt'; @endphp
                    <a href="{{ route($dashboardRoute) }}" class="text-xs md:text-sm font-black text-slate-600 hover:text-[#4f46e5] transition">Dash<span class="hidden md:inline">board</span></a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:block text-sm font-black text-slate-600 hover:text-[#4f46e5] transition dark:text-slate-300">Log In</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 md:px-6 md:py-2.5 bg-[#4f46e5] text-white rounded-xl font-black text-xs md:text-sm shadow-lg shadow-indigo-200 dark:shadow-none transition hover:scale-105 whitespace-nowrap">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero-gradient min-h-screen flex items-center justify-center pt-24 px-4 md:px-6 relative">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-500/10 rounded-full blur-[100px]"></div>

        <div class="max-w-5xl w-full text-center relative z-10 mt-10 md:mt-0">
            <div class="inline-block px-3 py-1.5 mb-4 md:mb-6 rounded-full bg-white border border-slate-100 text-[#4f46e5] text-xs md:text-sm font-bold shadow-sm whitespace-nowrap">
                🚀 Digitalisasi Keuangan Desa 4.0
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-7xl font-black text-[#000000] mb-6 md:mb-8 tracking-tight leading-tight">
                Transparansi Kas Iuran Warga <br class="hidden md:block">
                RW 04 Kalitanjung Timur
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-[#4f46e5] mb-8 md:mb-12 max-w-2xl mx-auto leading-relaxed font-bold sub-judul-utama px-2">
                Membangun kepercayaan warga melalui digitalisasi laporan keuangan yang akurat, otomatis, dan dapat diakses kapan saja.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 md:gap-5 justify-center px-4 md:px-0">
                @auth
                    @php $dashboardRoute = Auth::user()->role === 'RW' ? 'dashboard.rw' : 'dashboard.rt'; @endphp
                    <a href="{{ route($dashboardRoute) }}" class="px-6 md:px-10 py-3 md:py-4 bg-[#4f46e5] text-white rounded-xl md:rounded-2xl font-black text-base md:text-lg shadow-xl shadow-indigo-200 dark:shadow-none w-full md:w-auto">
                        Masuk ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 md:px-10 py-3 md:py-4 bg-[#4f46e5] text-white rounded-xl md:rounded-2xl font-black text-base md:text-lg shadow-xl shadow-indigo-200 dark:shadow-none w-full md:w-auto">
                        Masuk ke Sistem
                    </a>
                    <a href="{{ route('register') }}" class="px-6 md:px-10 py-3 md:py-4 bg-white dark:bg-slate-800 text-[#000000] dark:text-white border border-slate-200 dark:border-slate-700 rounded-xl md:rounded-2xl font-black text-base md:text-lg shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition w-full md:w-auto">
                        Daftar Pengurus
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <section class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10 md:mb-16">
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-4 px-2">Fitur Utama Platform</h2>
                <p class="text-[#4f46e5] max-w-xl mx-auto text-base md:text-lg font-bold px-4">Dilengkapi dengan teknologi otomasi terdepan untuk memudahkan tugas Bendahara.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm transition hover:shadow-md">
                    <div class="feature-icon-pastel pastel-indigo icon-fitur">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-[#000000]">Pencatatan Otomatis</h3>
                    <p class="text-slate-600 leading-relaxed font-bold">Sistem cerdas mendeteksi iuran <strong>IWK (Rp 3.000)</strong> & <strong>Andon (Rp 5.000)</strong> berdasarkan status warga.</p>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm transition hover:shadow-md">
                    <div class="feature-icon-pastel pastel-emerald icon-fitur">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-[#000000]">Monitoring Real-time</h3>
                    <p class="text-slate-600 leading-relaxed font-bold">Pantau grafik tunggakan bulanan, aliran kas, dan saldo akhir tiap unit RT secara instan.</p>
                </div>

                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-50 shadow-sm transition hover:shadow-md">
                    <div class="feature-icon-pastel pastel-amber icon-fitur">
                        <i class="fas fa-desktop text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-4 text-[#000000]">Laporan Publik</h3>
                    <p class="text-slate-600 leading-relaxed font-bold">Ekspor laporan keuangan format <strong>A3 (Landscape)</strong> untuk publikasi mading warga.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-8 md:p-16 rounded-[2rem] md:rounded-[3rem] text-center border border-slate-50 shadow-sm">
                <h2 class="text-3xl md:text-5xl font-black mb-6 md:mb-8 text-[#000000]">Mengapa Digitalisasi IWK?</h2>
                <p class="text-base md:text-xl text-slate-600 max-w-4xl mx-auto leading-relaxed font-bold">
                    Sistem Iuran Warga (IWK) RW 04 Kalitanjung Timur dikembangkan untuk menggantikan pencatatan manual yang rentan kesalahan. 
                    Dengan digitalisasi, transparansi keuangan antara pengurus RT dan warga dapat terjaga, terutama dalam membedakan iuran warga Pribumi dan Andon secara akurat.
                </p>
            </div>
        </div>
    </section>

    <section id="faq" class="py-24 px-6 no-print">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-black text-center mb-10 md:mb-12 text-[#000000]">Pertanyaan Sering Diajukan (FAQ)</h2>
            <div class="space-y-4">
                <details class="group bg-white p-8 rounded-2xl border border-slate-50 shadow-sm cursor-pointer overflow-hidden transition-all duration-300">
                    <summary class="flex justify-between items-center font-black text-lg list-none">
                        Apa perbedaan IWK dan Andon?
                        <span class="text-[#4f46e5] transition-transform duration-300 group-open:rotate-180">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="mt-6 pt-6 border-t border-slate-50 text-slate-600 font-bold leading-relaxed">
                        IWK (Iuran Warga Kampung) sebesar Rp 3.000 adalah iuran sukarela bagi warga pribumi, sedangkan Andon sebesar Rp 5.000 adalah iuran bagi warga pendatang atau yang mengontrak.
                    </div>
                </details>

                <details class="group bg-white p-8 rounded-2xl border border-slate-50 shadow-sm cursor-pointer overflow-hidden transition-all duration-300">
                    <summary class="flex justify-between items-center font-black text-lg list-none">
                        Bagaimana jika terjadi salah input?
                        <span class="text-[#4f46e5] transition-transform duration-300 group-open:rotate-180">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="mt-6 pt-6 border-t border-slate-50 text-slate-600 font-bold leading-relaxed">
                        Jangan khawatir, hanya akun Bendahara (Admin) yang memiliki otoritas untuk memperbaiki atau menghapus data transaksi demi menjaga integritas data.
                    </div>
                </details>
            </div>
        </div>
    </section>
    
    <section id="panduan" class="py-24 px-6 no-print">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 md:px-6 py-2 rounded-full bg-indigo-50 text-[#4f46e5] font-black text-[10px] md:text-xs uppercase tracking-widest mb-6">
                    <i class="fas fa-book-open"></i> Pusat Bantuan
                </div>
                <h2 class="text-3xl md:text-5xl font-black mb-4 md:mb-6 text-[#000000]">Buku Panduan Pengguna</h2>
                <p class="text-base md:text-xl text-[#4f46e5] font-bold max-w-2xl mx-auto mb-10">Panduan lengkap untuk mempermudah tugas pengurus RW 04 Kalitanjung Timur.</p>
            </div>

            <div class="space-y-12">
                <!-- BAGIAN 1: ADMIN RW -->
                <div class="guide-card">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-16 h-16 bg-[#eef2ff] rounded-2xl flex items-center justify-center text-[#4f46e5]">
                            <i class="fas fa-user-shield text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-black text-[#000000]">Bagian 1: Panduan Menu & Akses (Bendahara RW)</h3>
                            <p class="text-[#4f46e5] font-black text-xs uppercase tracking-widest mt-1">PUSAT KENDALI SISTEM & PENGATURAN UTAMA</p>
                        </div>
                    </div>

                    <div class="mb-12">
                        <h4 class="text-xl font-black mb-8 text-[#000000] flex items-center gap-3">
                            <i class="fas fa-home text-[#4f46e5]"></i> Halaman Depan (Akses Awal)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="guide-sub-card">
                                <span class="block font-black text-[#4f46e5] text-xs mb-4 uppercase tracking-widest">DAFTAR AKUN PENGURUS</span>
                                <p class="text-[#000000] font-bold leading-relaxed">Klik tombol ini jika Anda adalah petugas baru yang ingin mendaftar. Masukkan Nama, Email, dan Password untuk mulai bekerja.</p>
                            </div>
                            <div class="guide-sub-card">
                                <span class="block font-black text-[#4f46e5] text-xs mb-4 uppercase tracking-widest">MASUK KE SISTEM</span>
                                <p class="text-[#000000] font-bold leading-relaxed">Jika sudah punya akun, klik tombol <strong>Masuk</strong> untuk melihat catatan uang kas dan data warga.</p>
                            </div>
                            <div class="guide-sub-card">
                                <span class="block font-black text-[#4f46e5] text-xs mb-4 uppercase tracking-widest">ATUR TEMA (IKON GEAR)</span>
                                <p class="text-[#000000] font-bold leading-relaxed">Klik ikon gambar bulan di pojok kanan atas agar layar menjadi <strong>Mode Gelap</strong>. Ini bagus agar mata tidak cepat lelah.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xl font-black mb-8 text-[#000000] flex items-center gap-3">
                            <i class="fas fa-bars text-[#4f46e5]"></i> Panduan Menu Utama (Sidebar)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                            <div class="flex gap-6 items-center">
                                <div class="guide-icon-box">
                                    <i class="fas fa-th-large text-xl"></i>
                                </div>
                                <div>
                                    <span class="block font-black text-[#4f46e5] text-xs mb-1 uppercase tracking-widest">DASHBOARD</span>
                                    <p class="text-[#000000] font-bold">Melihat ringkasan seluruh uang kas masuk dan sisa saldo di RT Anda.</p>
                                </div>
                            </div>
                            <div class="flex gap-6 items-center">
                                <div class="guide-icon-box">
                                    <i class="fas fa-users-cog text-xl"></i>
                                </div>
                                <div>
                                    <span class="block font-black text-[#4f46e5] text-xs mb-1 uppercase tracking-widest">MANAJEMEN USER</span>
                                    <p class="text-[#000000] font-bold">Mengatur akun pengurus lain seperti Admin atau Petugas di tiap wilayah.</p>
                                </div>
                            </div>
                            <div class="flex gap-6 items-center">
                                <div class="guide-icon-box">
                                    <i class="fas fa-tags text-xl"></i>
                                </div>
                                <div>
                                    <span class="block font-black text-[#4f46e5] text-xs mb-1 uppercase tracking-widest">MASTER KATEGORI</span>
                                    <p class="text-[#000000] font-bold">Membuat label untuk uang masuk (Contoh: Iuran) atau uang keluar (Contoh: Sampah).</p>
                                </div>
                            </div>
                            <div class="flex gap-6 items-center">
                                <div class="guide-icon-box">
                                    <i class="fas fa-address-book text-xl"></i>
                                </div>
                                <div>
                                    <span class="block font-black text-[#4f46e5] text-xs mb-1 uppercase tracking-widest">DATA WARGA</span>
                                    <p class="text-[#000000] font-bold">Mencatat nama penduduk dan nomor WhatsApp agar mudah dihubungi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: PETUGAS RT -->
                <div class="guide-card">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="guide-icon-box">
                            <i class="fas fa-desktop text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-black text-[#000000]">Bagian 2: Panduan Monitoring Bendahara (Wilayah RT)</h3>
                            <p class="text-[#4f46e5] font-black text-xs uppercase tracking-widest mt-1">OPERASIONAL WILAYAH & PENAGIHAN IURAN</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <div class="guide-sub-card">
                            <div class="flex items-center gap-3 mb-4">
                                <i class="fas fa-chart-line text-[#4f46e5] text-sm"></i>
                                <span class="block font-black text-[#4f46e5] text-xs uppercase tracking-widest">PANTAU SALDO RT</span>
                            </div>
                            <p class="text-[#000000] font-bold leading-relaxed">Petugas RT hanya melihat data wilayahnya sendiri. Lihat kotak <strong>Total Saldo Kas RT</strong> untuk tahu sisa uang di lingkungan Anda.</p>
                        </div>
                        <div class="guide-sub-card">
                            <div class="flex items-center gap-3 mb-4">
                                <i class="fas fa-exclamation-triangle text-rose-600 text-sm"></i>
                                <span class="block font-black text-rose-600 text-xs uppercase tracking-widest">DAFTAR BELUM BAYAR</span>
                            </div>
                            <p class="text-[#000000] font-bold leading-relaxed">Cek kotak merah <strong>Jumlah Menunggak</strong>. Ini adalah daftar otomatis warga yang belum membayar iuran bulan ini.</p>
                        </div>
                    </div>

                    <div class="whatsapp-banner mb-12">
                        <div class="flex flex-col md:flex-row items-center gap-10">
                            <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-full flex items-center justify-center shrink-0 border border-white/30">
                                <i class="fab fa-whatsapp text-5xl text-white"></i>
                            </div>
                            <div>
                                <h4 class="text-3xl font-black mb-2 tracking-tight">Ingatkan Warga Lewat WhatsApp</h4>
                                <p class="text-white font-bold text-lg leading-relaxed">Cukup klik tombol hijau bergambar WhatsApp di daftar tunggakan. Sistem akan otomatis mengirim pesan pengingat tagihan ke HP warga secara sopan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="guide-sub-card">
                        <div class="flex items-center gap-3 mb-4">
                            <i class="fas fa-edit text-[#4f46e5] text-sm"></i>
                            <span class="block font-black text-[#4f46e5] text-xs uppercase tracking-widest">MENCATAT IURAN RT</span>
                        </div>
                        <p class="text-[#000000] font-bold leading-relaxed">Saat mencatat iuran, Anda tinggal memilih nama warga di lingkungan Anda saja. Ini membuat pendaftaran iuran di lapangan jadi jauh lebih cepat dan mudah bagi petugas.</p>
                    </div>
                </div>

                <!-- TIPS KERJA RAPI -->
                <div class="guide-card">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                            <i class="fas fa-lightbulb text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-3xl font-black text-[#000000]">Tips Kerja Rapi & Jujur</h3>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-5">
                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center shrink-0 text-white mt-1">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <p class="text-lg font-bold text-[#000000]">Gunakan fitur Cetak PDF di akhir bulan agar ada bukti fisik yang bisa dilihat seluruh warga.</p>
                        </div>
                        <div class="flex items-start gap-5">
                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center shrink-0 text-white mt-1">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <p class="text-lg font-bold text-[#000000]">Pasang foto resmi di menu Profil Pengurus agar identitas Anda muncul resmi saat struk iuran dikirim ke warga.</p>
                        </div>
                        <div class="flex items-start gap-5">
                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center shrink-0 text-white mt-1">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <p class="text-lg font-bold text-[#000000]">Simpan uang iuran bulanan dan uang bantuan sosial secara terpisah di dalam laporan agar tidak bingung.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-24 px-4 md:px-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 md:p-12 rounded-[2rem] md:rounded-[4rem] border border-slate-50 shadow-sm text-center">
                <h2 class="text-2xl md:text-3xl font-black text-[#000000] mb-8 md:mb-12 tracking-tight">Cakupan Wilayah RW 04</h2>
                <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-16">
                    <div class="text-center group">
                        <div class="text-3xl md:text-4xl font-black text-[#4f46e5] mb-1 md:mb-2">RT 01</div>
                        <span class="text-slate-400 text-[10px] md:text-xs uppercase tracking-widest font-black">Sektor Timur</span>
                    </div>
                    <div class="w-16 h-px md:w-px md:h-16 bg-slate-100 block"></div>
                    <div class="text-center group">
                        <div class="text-3xl md:text-4xl font-black text-[#4f46e5] mb-1 md:mb-2">RT 02</div>
                        <span class="text-slate-400 text-[10px] md:text-xs uppercase tracking-widest font-black">Sektor Tengah</span>
                    </div>
                    <div class="w-16 h-px md:w-px md:h-16 bg-slate-100 block"></div>
                    <div class="text-center group">
                        <div class="text-3xl md:text-4xl font-black text-[#4f46e5] mb-1 md:mb-2">RT 03</div>
                        <span class="text-slate-400 text-[10px] md:text-xs uppercase tracking-widest font-black">Sektor Barat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Credit Scene / Meet Our Team Section -->
    <section id="meet-the-team" class="py-24 px-6 relative overflow-hidden tim-pengembang">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black mb-6 text-black tracking-tight">
                    Struktur Organisasi RW 04 Kalitanjung Timur
                </h2>
                <div class="h-1.5 w-32 bg-[#4f46e5] mx-auto rounded-full"></div>
            </div>

            <!-- BARIS 1: RW -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="team-card text-center" onclick="this.classList.toggle('expanded')">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-8 text-[#4f46e5]">
                        <i class="fas fa-user-tie text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-[#000000]">Toto S</h3>
                    <p class="text-xs font-black tracking-widest uppercase text-slate-400">Ketua RW 04</p>
                </div>
                <div class="team-card text-center" onclick="this.classList.toggle('expanded')">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-8 text-[#4f46e5]">
                        <i class="fas fa-file-alt text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-[#000000]">Sekretaris RW</h3>
                    <p class="text-xs font-black tracking-widest uppercase text-slate-400">Sekretaris</p>
                </div>
                <div class="team-card text-center" onclick="this.classList.toggle('expanded')">
                    <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-8 text-[#4f46e5]">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 text-[#000000]">Asrimawati</h3>
                    <p class="text-xs font-black tracking-widest uppercase text-slate-400">Bendahara RW</p>
                </div>
            </div>

            <!-- BARIS 2: SELURUH RT (SEJAJAR 3 KOLOM) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- RT 01 -->
                <div class="team-card p-6 rounded-3xl bg-indigo-50/30 border border-indigo-100" onclick="this.classList.toggle('expanded')">
                    <div class="text-center mb-6">
                        <span class="px-4 py-1.5 bg-indigo-500/10 rounded-full text-[10px] font-black text-indigo-500 uppercase tracking-widest">Wilayah RT 01</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-[#4f46e5] shadow-sm">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-black">Yayat Nurhayat</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Ketua</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-[#4f46e5] shadow-sm">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-black">Bambang</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RT 02 -->
                <div class="team-card p-6 rounded-3xl bg-indigo-50/30 border border-indigo-100" onclick="this.classList.toggle('expanded')">
                    <div class="text-center mb-6">
                        <span class="px-4 py-1.5 bg-indigo-500/10 rounded-full text-[10px] font-black text-indigo-500 uppercase tracking-widest">Wilayah RT 02</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-[#4f46e5] shadow-sm">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-black">Ketua RT 02</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Ketua</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-[#4f46e5] shadow-sm">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-black">Bendahara RT 02</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RT 03 -->
                <div class="team-card p-6 rounded-3xl bg-indigo-50/30 border border-indigo-100" onclick="this.classList.toggle('expanded')">
                    <div class="text-center mb-6">
                        <span class="px-4 py-1.5 bg-indigo-500/10 rounded-full text-[10px] font-black text-indigo-500 uppercase tracking-widest">Wilayah RT 03</span>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-[#4f46e5] shadow-sm">
                                <i class="fas fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-black">Ketua RT 03</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Ketua</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-[#4f46e5] shadow-sm">
                                <i class="fas fa-coins text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-black">Bendahara RT 03</h4>
                                <p class="text-[9px] font-black tracking-widest uppercase text-slate-400">Bendahara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-20 flex flex-col items-center gap-12 text-center">
                <a href="https://www.google.com/maps/search/?api=1&query=RT.02+RW.04+Kalitanjung+Timur+Kota+Cirebon+45143" target="_blank" class="inline-flex items-center gap-3 px-8 py-3 bg-white rounded-full border border-slate-100 shadow-sm text-sm font-bold text-black hover:shadow-md transition">
                    <i class="fa-solid fa-location-dot text-rose-500 icon-tim"></i>
                    <span class="nama-kampus">Lokasi PKM: RT.02 RW.04 Kalitanjung Timur, Kota Cirebon 45143</span>
                </a>
                
                <a href="https://www.google.com/maps/search/?api=1&query=STMIK+IKMI+Cirebon" target="_blank" class="group hover:scale-105 transition">
                    <h4 class="text-4xl md:text-6xl font-black tracking-[0.2em] text-black uppercase nama-kampus">
                        STMIK IKMI CIREBON
                    </h4>
                </a>
            </div>
        </div>
    </section>

    <style>
        .dashboard-footer {
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            background: rgba(15, 23, 42, 0.7);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            color: #f8fafc;
            margin-top: auto;
        }
        .light-mode .dashboard-footer {
            background: rgba(255, 255, 255, 0.85);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            color: #0f172a;
        }
        .footer-team-item { transition: all 0.3s ease; }
        .footer-team-item:hover { transform: translateX(5px); color: #818cf8; }
        .light-mode .footer-team-item:hover { color: #4f46e5; }
    </style>
    <footer class="dashboard-footer mt-12 py-10 px-6 sm:px-10 lg:px-12 transition-all duration-300 no-print">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 text-left">
            <!-- Tentang Projek -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-[#4f46e5] rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                    <h3 class="text-xl font-black tracking-tight text-white dark:text-white">Sistem IWK</h3>
                </div>
                <p class="text-sm opacity-80 leading-relaxed font-medium">
                    Sistem Informasi Iuran Warga (IWK) merupakan inovasi digitalisasi administrasi keuangan tingkat rukun warga di lingkungan <strong>RW 04 Kalitanjung Timur</strong>. Mengutamakan transparansi, efisiensi, dan akuntabilitas.
                </p>
            </div>

            <!-- Tim Pengembang -->
            <div>
                <h4 class="text-sm font-black uppercase tracking-widest mb-6 opacity-60">Tim Pengembang (STMIK IKMI)</h4>
                <ul class="space-y-4 text-sm font-bold">
                    <li class="footer-team-item flex items-center gap-3 cursor-default">
                        <i class="fas fa-terminal w-4 text-center"></i>
                        <div>Sekar Tanjung Maulidia <span class="block text-[10px] opacity-60 font-normal">Manager Project + Backend</span></div>
                    </li>
                    <li class="footer-team-item flex items-center gap-3 cursor-default">
                        <i class="fas fa-palette w-4 text-center"></i>
                        <div>Nurkholissah Anindia M. <span class="block text-[10px] opacity-60 font-normal">UI/UX Designer + Tester</span></div>
                    </li>
                    <li class="footer-team-item flex items-center gap-3 cursor-default">
                        <i class="fas fa-desktop w-4 text-center"></i>
                        <div>Rachmawati Sya'adah <span class="block text-[10px] opacity-60 font-normal">Assistance Manager + Frontend</span></div>
                    </li>
                    <li class="footer-team-item flex items-center gap-3 cursor-default">
                        <i class="fas fa-microchip w-4 text-center"></i>
                        <div>Suci Febriyanti <span class="block text-[10px] opacity-60 font-normal">Analis + Database Designer</span></div>
                    </li>
                    <li class="footer-team-item flex items-center gap-3 cursor-default">
                        <i class="fas fa-book-open w-4 text-center"></i>
                        <div>Chamailia <span class="block text-[10px] opacity-60 font-normal">Dokumentasi + Jurnal + LO</span></div>
                    </li>
                </ul>
            </div>

            <!-- Lokasi & Kontak -->
            <div>
                <h4 class="text-sm font-black uppercase tracking-widest mb-6 opacity-60">Lokasi Pusat</h4>
                <a href="https://www.google.com/maps/search/?api=1&query=RT.02+RW.04+Kalitanjung+Timur+Kota+Cirebon+45143" target="_blank" class="block group">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 border border-white/5 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 transition-all duration-300">
                        <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-map-marker-alt text-indigo-400 group-hover:animate-bounce"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold leading-relaxed">Sekretariat RW 04</p>
                            <p class="text-xs opacity-70 mt-1">Kalitanjung Timur, Kec. Harjamukti, Kota Cirebon, Jawa Barat 45143</p>
                            <div class="mt-4 pt-4 border-t border-white/5 space-y-2">
                                <p class="text-xs font-bold flex items-center gap-2">
                                    <i class="fas fa-phone text-indigo-400 text-[10px]"></i>
                                    +62 812-3456-7890
                                </p>
                                <p class="text-xs font-bold flex items-center gap-2">
                                    <i class="fas fa-envelope text-indigo-400 text-[10px]"></i>
                                    admin@iwk-rw04.com
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                
                <div class="mt-8 pt-8 border-t border-white/10 flex justify-between items-center text-xs font-bold opacity-50">
                    <span>&copy; {{ date('Y') }} Hak Cipta Dilindungi.</span>
                    <span>v1.0.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- FORMAL PRINT ONLY GUIDE (Hidden on screen) -->
    <div id="formal-print-guide" style="display: none;">
        <div style="text-align: center; border-bottom: 3px solid black; padding-bottom: 20px; margin-bottom: 30px;">
            <h1 style="font-size: 28pt; font-weight: 900; margin-bottom: 5px; color: black;">BUKU PANDUAN PENGGUNA - db_iwk_rw04</h1>
            <h2 style="font-size: 20pt; font-weight: 800; color: black; letter-spacing: 2px;">STMIK IKMI CIREBON</h2>
        </div>

        <div class="page-break-avoid" style="margin-bottom: 40px;">
            <h3 style="font-size: 16pt; border-left: 10px solid #4f46e5; padding-left: 15px; margin-bottom: 20px; color: black;">PANDUAN AKSES & FITUR ADMIN RT</h3>
            <p style="font-size: 12pt; line-height: 1.6; color: black;">
                <strong>1. Akses Sistem:</strong> Gunakan menu Login untuk masuk atau Daftar Akun untuk petugas baru. Ikon ⚙️ (Gear) berfungsi untuk mengatur tema visual (Mode Terang/Gelap).<br>
                <strong>2. Data Warga:</strong> Digunakan untuk mendata status warga (Pribumi/Andon) dan nomor WhatsApp.<br>
                <strong>3. Catat Iuran:</strong> Menu utama untuk memasukkan nominal iuran masuk (Form A) dan pengeluaran operasional (Form B).<br>
                <strong>4. WhatsApp Penagihan:</strong> Klik tombol hijau pada daftar warga penunggak untuk mengirim notifikasi tagihan otomatis.
            </p>
        </div>

        <div class="page-break-avoid" style="margin-bottom: 40px;">
            <h3 style="font-size: 16pt; border-left: 10px solid #1e293b; padding-left: 15px; margin-bottom: 20px; color: black;">MONITORING GLOBAL & MANAJEMEN ADMIN RW</h3>
            <p style="font-size: 12pt; line-height: 1.6; color: black;">
                <strong>1. Dashboard Global:</strong> Memantau total kas seluruh wilayah RW 04, total penduduk, dan daftar penunggak secara real-time.<br>
                <strong>2. Manajemen Data:</strong> Gunakan tombol <strong>Edit (Ikon Pensil)</strong> untuk mengubah data yang salah dan tombol <strong>Hapus (Ikon Sampah)</strong> untuk membuang data tidak valid.<br>
            </p>
        </div>

        <div class="page-break-avoid">
            <h3 style="font-size: 16pt; border-left: 10px solid #059669; padding-left: 15px; margin-bottom: 20px; color: black;">LAPORAN KEUANGAN & PERTANGGUNGJAWABAN</h3>
            <p style="font-size: 12pt; line-height: 1.6; color: black;">
                Sistem menghasilkan laporan otomatis yang mencakup:<br>
                - <strong>Total Debit:</strong> Seluruh uang kas yang masuk.<br>
                - <strong>Total Kredit:</strong> Seluruh pengeluaran operasional wilayah.<br>
                - <strong>Saldo Akhir:</strong> Sisa saldo kas yang terhitung secara akurat.<br>
                - <strong>Lembar Pengesahan:</strong> Tempat tanda tangan pengurus sebagai bukti pertanggungjawaban fisik.
            </p>
        </div>
    </div>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');

        function setTheme(theme) {
            if (theme === 'light') {
                document.body.classList.remove('dark');
                lightIcon.style.display = 'block';
                darkIcon.style.display = 'none';
            } else {
                document.body.classList.add('dark');
                darkIcon.style.display = 'block';
                lightIcon.style.display = 'none';
            }
            localStorage.setItem('theme', theme);
        }

        // Initialize theme on load
        const savedTheme = localStorage.getItem('theme') || 'dark';
        setTheme(savedTheme);

        themeToggleBtn.addEventListener('click', function() {
            const currentTheme = document.body.classList.contains('dark') ? 'light' : 'dark';
            setTheme(currentTheme);
        });
    </script>
</body>
</html>