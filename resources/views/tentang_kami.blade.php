<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Tim Pengembang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(226, 232, 240, 0.8); }
    </style>
</head>
<body class="antialiased text-slate-800">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 py-4 px-6 glass-card shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 transition font-black">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <div class="font-black text-xl tracking-tight hidden md:block">STMIK IKMI CIREBON</div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="pt-32 pb-20 px-6 bg-gradient-to-br from-indigo-50 to-white text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-block px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full font-bold text-sm mb-6 shadow-sm">
                🎓 Mahasiswa Sistem Informasi
            </div>
            <h1 class="text-4xl md:text-6xl font-black mb-6 text-slate-900 leading-tight tracking-tight">
                Tim Pengembang <br> <span class="text-indigo-600">Digitalisasi IWK</span>
            </h1>
            <p class="text-lg text-slate-600 font-medium leading-relaxed">
                Kami adalah mahasiswa STMIK IKMI Cirebon yang berdedikasi membangun solusi digital untuk mempermudah tata kelola keuangan dan administrasi lingkungan di RW 04 Kalitanjung Timur.
            </p>
        </div>
    </header>

    <!-- Team Section -->
    <section class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-slate-900 mb-4">Kenali Anggota Tim Kami</h2>
                <p class="text-slate-500 font-medium">Silakan edit file <code>resources/views/tentang_kami.blade.php</code> untuk mengisi nama-nama anggota kelompok Anda.</p>
            </div>

            <!-- Team Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Member 1 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 text-center group hover:-translate-y-2">
                    <div class="w-24 h-24 mx-auto bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 shadow-inner">
                        <i class="fas fa-user-astronaut text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-black mb-1 text-slate-800">[Nama Anggota 1]</h3>
                    <p class="text-indigo-600 text-sm font-bold mb-4">[NIM Mahasiswa]</p>
                    <p class="text-slate-500 text-sm font-medium">Peran / Tugas: (Contoh: Project Manager / Fullstack)</p>
                </div>

                <!-- Member 2 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 text-center group hover:-translate-y-2">
                    <div class="w-24 h-24 mx-auto bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300 shadow-inner">
                        <i class="fas fa-user-ninja text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-black mb-1 text-slate-800">[Nama Anggota 2]</h3>
                    <p class="text-emerald-600 text-sm font-bold mb-4">[NIM Mahasiswa]</p>
                    <p class="text-slate-500 text-sm font-medium">Peran / Tugas: (Contoh: System Analyst / Backend)</p>
                </div>

                <!-- Member 3 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 text-center group hover:-translate-y-2">
                    <div class="w-24 h-24 mx-auto bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-inner">
                        <i class="fas fa-user-graduate text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-black mb-1 text-slate-800">[Nama Anggota 3]</h3>
                    <p class="text-amber-600 text-sm font-bold mb-4">[NIM Mahasiswa]</p>
                    <p class="text-slate-500 text-sm font-medium">Peran / Tugas: (Contoh: UI/UX Designer / Frontend)</p>
                </div>
                
                <!-- Member 4 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 text-center group hover:-translate-y-2">
                    <div class="w-24 h-24 mx-auto bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300 shadow-inner">
                        <i class="fas fa-user-tie text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-black mb-1 text-slate-800">[Nama Anggota 4]</h3>
                    <p class="text-rose-600 text-sm font-bold mb-4">[NIM Mahasiswa]</p>
                    <p class="text-slate-500 text-sm font-medium">Peran / Tugas: (Contoh: Database Administrator)</p>
                </div>
                
                <!-- Member 5 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 text-center group hover:-translate-y-2">
                    <div class="w-24 h-24 mx-auto bg-cyan-50 text-cyan-500 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300 shadow-inner">
                        <i class="fas fa-user-secret text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-black mb-1 text-slate-800">[Nama Anggota 5]</h3>
                    <p class="text-cyan-600 text-sm font-bold mb-4">[NIM Mahasiswa]</p>
                    <p class="text-slate-500 text-sm font-medium">Peran / Tugas: (Contoh: Quality Assurance)</p>
                </div>

            </div>
            
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-slate-900 text-center text-slate-400">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-xl font-black text-white mb-2 tracking-widest uppercase">STMIK IKMI CIREBON</h3>
            <p class="mb-8 text-sm font-medium text-slate-300">Program Studi Sistem Informasi</p>
            <div class="w-16 h-1 bg-indigo-500 mx-auto rounded-full mb-8"></div>
            <p class="text-xs">&copy; {{ date('Y') }} Hak Cipta Terpelihara. Dikembangkan untuk masyarakat RW 04 Kalitanjung Timur.</p>
        </div>
    </footer>

</body>
</html>
