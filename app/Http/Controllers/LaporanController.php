<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanBuku;
use App\Models\TransaksiPeminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $peminjaman = Peminjaman::withCount('peminjamanBukus')
            ->when($dari && $sampai, function ($query) use ($dari, $sampai) {
                $query->whereBetween('tgl_peminjaman', [$dari, $sampai]);
            })
            ->paginate(10)
            ->withQueryString();

        return view('laporan-admin.index', compact('peminjaman', 'dari', 'sampai'));
    }

    public function detail($id)
    {
        $data = PeminjamanBuku::with('buku', 'peminjaman')->where('peminjaman_id', $id)->paginate(10);
        return view('laporan-admin.detail', compact('data'));
    }

    /** Riwayat peminjaman buku (TransaksiPeminjaman) dengan filter tanggal */
    public function transaksi(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $items = TransaksiPeminjaman::with(['buku', 'user'])
            ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                $q->whereBetween('tgl_peminjaman', [$dari, $sampai]);
            })
            ->latest('tgl_peminjaman')
            ->paginate(15)
            ->withQueryString();

        return view('laporan-transaksi.index', compact('items', 'dari', 'sampai'));
    }

    /** Laporan data buku */
    public function buku(Request $request)
    {
        $q = $request->get('q');
        $buku = \App\Models\Buku::with(['kategoris', 'penerbit'])
            ->when($q, fn($query) => $query->where('judul', 'like', '%' . $q . '%')
                ->orWhere('pengarang', 'like', '%' . $q . '%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();
        return view('laporan-buku.index', compact('buku', 'q'));
    }

    /** Download PDF laporan data buku */
    public function bukuPdf(Request $request)
    {
        try {
            $buku = \App\Models\Buku::with(['kategoris', 'penerbit'])->orderBy('judul')->get();
            $pdf = Pdf::loadView('laporan-buku.pdf', compact('buku'));
            $pdf->setPaper('a4', 'portrait');
            return $pdf->download('laporan-data-buku-' . date('Y-m-d') . '.pdf');
        } catch (\Throwable $e) {
            return redirect()->route('laporan.buku')->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    /** Laporan data user (admin only) */
    public function user(Request $request)
    {
        $q = $request->get('q');
        $users = \App\Models\User::where('role', 'user')
            ->when($q, fn($query) => $query->where('name', 'like', '%' . $q . '%')
                ->orWhere('email', 'like', '%' . $q . '%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();
        return view('laporan-user.index', compact('users', 'q'));
    }

    /** Download PDF laporan data user */
    public function userPdf(Request $request)
    {
        try {
            $users = \App\Models\User::where('role', 'user')->orderBy('name')->get();
            $pdf = Pdf::loadView('laporan-user.pdf', compact('users'));
            $pdf->setPaper('a4', 'portrait');
            return $pdf->download('laporan-data-user-' . date('Y-m-d') . '.pdf');
        } catch (\Throwable $e) {
            return redirect()->route('laporan.user')->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    /** Download PDF laporan transaksi */
    public function transaksiPdf(Request $request)
    {
        try {
            $dari = $request->dari;
            $sampai = $request->sampai;

            $items = TransaksiPeminjaman::with(['buku', 'user'])
                ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                    $q->whereBetween('tgl_peminjaman', [$dari, $sampai]);
                })
                ->latest('tgl_peminjaman')
                ->get();

            $pdf = Pdf::loadView('laporan-transaksi.pdf', compact('items', 'dari', 'sampai'));
            $pdf->setPaper('a4', 'portrait');

            return $pdf->download('laporan-riwayat-peminjaman-' . date('Y-m-d') . '.pdf');
        } catch (\Throwable $e) {
            return redirect()
                ->route('laporan.transaksi', $request->only(['dari', 'sampai']))
                ->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }
    public function destroy($id)
{
    $data = TransaksiPeminjaman::findOrFail($id);
    $data->delete();

    return back()->with('success','Data berhasil dihapus');
}
}
