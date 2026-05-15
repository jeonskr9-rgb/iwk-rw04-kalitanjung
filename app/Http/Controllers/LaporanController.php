<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKas;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedRt = $request->rt_id;
        $selectedKuartal = $request->kuartal;

        // Base Query
        $query = TransaksiKas::with('category', 'warga')->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc');
        $totalMasukQuery = TransaksiKas::where('jenis_transaksi', 'Masuk');
        $totalKeluarQuery = TransaksiKas::where('jenis_transaksi', 'Keluar');

        // Filter RT
        if ($selectedRt) {
            $query->where('rt_id', $selectedRt);
            $totalMasukQuery->where('rt_id', $selectedRt);
            $totalKeluarQuery->where('rt_id', $selectedRt);
        }

        // Filter Kuartal
        if ($selectedKuartal) {
            $year = now()->format('Y');
            switch ($selectedKuartal) {
                case 1: $startMonth = 1; $endMonth = 3; break;
                case 2: $startMonth = 4; $endMonth = 6; break;
                case 3: $startMonth = 7; $endMonth = 9; break;
                case 4: $startMonth = 10; $endMonth = 12; break;
                default: $startMonth = 1; $endMonth = 3; break;
            }
            $startDate = \Carbon\Carbon::create($year, $startMonth, 1)->startOfMonth()->format('Y-m-d');
            $endDate = \Carbon\Carbon::create($year, $endMonth, 1)->endOfMonth()->format('Y-m-d');
            
            $query->whereBetween('tanggal', [$startDate, $endDate]);
            $totalMasukQuery->whereBetween('tanggal', [$startDate, $endDate]);
            $totalKeluarQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }

        $transaksis = $query->get();
        $totalMasuk = $totalMasukQuery->sum('jumlah');
        $totalKeluar = $totalKeluarQuery->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        $rts = \App\Models\RtUnit::all();
        $rtIdForProfile = ($user->isAdmin() && $selectedRt) ? $selectedRt : $user->rt_id;
        $profil = \App\Models\ProfilRt::where('rt_id', $rtIdForProfile)->first();
        $profilRW = \App\Models\ProfilRt::whereNull('rt_id')->first();

        return view('laporan.index', compact('transaksis', 'totalMasuk', 'totalKeluar', 'saldoAkhir', 'rts', 'selectedRt', 'selectedKuartal', 'user', 'profil', 'profilRW'));
    }

    public function print()
    {
        $user = Auth::user();
        // Print order: oldest first (lama ke baru)
        $transaksis = TransaksiKas::with('category', 'warga')->orderBy('tanggal', 'asc')->orderBy('created_at', 'asc')->get();
        $totalMasuk = TransaksiKas::where('jenis_transaksi', 'Masuk')->sum('jumlah');
        $totalKeluar = TransaksiKas::where('jenis_transaksi', 'Keluar')->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        return view('laporan.print', compact('transaksis', 'totalMasuk', 'totalKeluar', 'saldoAkhir'));
    }

    // Existing methods for PDF export
    private function exportKuartal($rtId, $kuartal = null)
    {
        \Carbon\Carbon::setLocale('id');
        $now = now();
        $year = $now->format('Y');

        // Jika kuartal tidak dipilih, gunakan kuartal saat ini
        if (!$kuartal) {
            $currentMonth = (int)$now->format('m');
            $kuartal = ceil($currentMonth / 3);
        }

        // Tentukan rentang bulan berdasarkan kuartal
        switch ($kuartal) {
            case 1: $startMonthNum = 1; $endMonthNum = 3; break;
            case 2: $startMonthNum = 4; $endMonthNum = 6; break;
            case 3: $startMonthNum = 7; $endMonthNum = 9; break;
            case 4: $startMonthNum = 10; $endMonthNum = 12; break;
            default: $startMonthNum = 1; $endMonthNum = 3; break;
        }

        $startOfQuarter = \Carbon\Carbon::create($year, $startMonthNum, 1, 0, 0, 0)->startOfMonth();
        $endOfQuarter = \Carbon\Carbon::create($year, $endMonthNum, 1, 23, 59, 59)->endOfMonth();
        
        $startMonthName = strtoupper($startOfQuarter->translatedFormat('F'));
        $endMonthName = strtoupper($endOfQuarter->translatedFormat('F'));

        // Saldo sebelum periode
        $masukSblm = TransaksiKas::when($rtId, function ($query) use ($rtId) {
                return $query->where('rt_id', $rtId);
            })
            ->where('tanggal', '<', $startOfQuarter)
            ->where('jenis_transaksi', 'Masuk')
            ->sum('jumlah');
            
        $keluarSblm = TransaksiKas::when($rtId, function ($query) use ($rtId) {
                return $query->where('rt_id', $rtId);
            })
            ->where('tanggal', '<', $startOfQuarter)
            ->where('jenis_transaksi', 'Keluar')
            ->sum('jumlah');
            
        $saldoAwal = $masukSblm - $keluarSblm;

        // Ambil transaksi dalam rentang kuartal
        $transaksis = TransaksiKas::with(['category', 'warga'])
                        ->when($rtId, function ($query) use ($rtId) {
                            return $query->where('rt_id', $rtId);
                        })
                        ->whereBetween('tanggal', [$startOfQuarter->format('Y-m-d'), $endOfQuarter->format('Y-m-d')])
                        ->orderBy('tanggal', 'asc')
                        ->orderBy('created_at', 'asc')
                        ->get();

        $grouped = $transaksis->groupBy(function ($item) {
            return $item->category ? $item->category->name : 'Tanpa Kategori';
        });

        $profil = \App\Models\ProfilRt::where('rt_id', $rtId)->first();
        $profilRW = \App\Models\ProfilRt::whereNull('rt_id')->first();

        return [
            'transaksis' => $transaksis,
            'grouped' => $grouped,
            'startMonth' => $startMonthName,
            'endMonth' => $endMonthName,
            'year' => $year,
            'saldoAwal' => $saldoAwal,
            'profil' => $profil,
            'profilRW' => $profilRW,
        ];
    }

    public function cetakA3(Request $request)
    {
        $user = Auth::user();
        $rtId = ($user->isAdmin() && $request->filled('rt_id')) ? $request->rt_id : $user->rt_id;
        $kuartal = $request->query('kuartal');
        
        $data = $this->exportKuartal($rtId, $kuartal);
        $data['user'] = $user;
        $data['wilayahFilter'] = $rtId ? \App\Models\RtUnit::find($rtId)->nomor_rt : 'Semua RT';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.a3', $data);
        $pdf->setPaper('a3', 'landscape');
        
        return $pdf->download('laporan iwk triwulan ' . ($kuartal ?? 'saat ini') . '.pdf');
    }

    public function cetakA4(Request $request)
    {
        $user = Auth::user();
        $rtId = ($user->isAdmin() && $request->filled('rt_id')) ? $request->rt_id : $user->rt_id;
        $kuartal = $request->query('kuartal');

        $data = $this->exportKuartal($rtId, $kuartal);
        $data['user'] = $user;
        $data['wilayahFilter'] = $rtId ? \App\Models\RtUnit::find($rtId)->nomor_rt : 'Semua RT';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.a4', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan iwk triwulan ' . ($kuartal ?? 'saat ini') . '.pdf');
    }

    public function edit(TransaksiKas $transaksi)
    {
        $categories = Category::all();
        $wargas = \App\Models\Warga::all();
        return view('laporan.edit', compact('transaksi', 'categories', 'wargas'));
    }

    public function update(Request $request, TransaksiKas $transaksi)
    {
        $request->validate([
            'uraian' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:Masuk,Keluar',
            'kategori_id' => 'nullable|exists:categories,id',
            'warga_id' => 'nullable|exists:wargas,id',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(TransaksiKas $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
