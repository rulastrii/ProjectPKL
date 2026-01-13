<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklmagang;
use App\Models\PengajuanPklSiswa;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanPklController extends Controller
{
    /**
     * List pengajuan guru
     */
    public function index(Request $request)
    {
        $guruId = Auth::id();

        $query = PengajuanPklmagang::where('created_id', $guruId)
            ->with(['siswa', 'sekolah']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('no_surat', 'like', "%{$request->search}%")
                  ->orWhereHas('sekolah', fn ($s) =>
                        $s->where('nama', 'like', "%{$request->search}%")
                  );
            });
        }

        $pengajuans = $query
            ->orderByDesc('created_date')
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return view('guru.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Detail pengajuan
     */
    public function show($id)
    {
        $pengajuan = PengajuanPklmagang::with(['siswa', 'sekolah'])
            ->findOrFail($id);

        return view('guru.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Form create
     */
    public function create()
    {
        $sekolah = Sekolah::all();
        return view('guru.pengajuan.create', compact('sekolah'));
    }

    /**
     * Simpan pengajuan (draft)
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|string',
            'tgl_surat' => 'required|date',
            'sekolah_id' => 'required|exists:sekolah,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'email_guru' => 'required|email',
            'file_surat_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'catatan' => 'nullable|string',
        ]);

        $filePath = $request->file('file_surat_path')
            ? $request->file('file_surat_path')->store('surat', 'public')
            : null;

        $pengajuan = PengajuanPklmagang::create([
            'no_surat' => $request->no_surat,
            'tgl_surat' => $request->tgl_surat,
            'sekolah_id' => $request->sekolah_id,
            'jumlah_siswa' => 0,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'status' => 'draft',
            'file_surat_path' => $filePath,
            'catatan' => $request->catatan,
            'email_guru' => $request->email_guru,
            'created_id' => Auth::id(),
            'created_date' => now(),
            'is_active' => 1,
        ]);

        return redirect()
            ->route('guru.pengajuan.edit', $pengajuan->id)
            ->with('success', 'Pengajuan draft berhasil dibuat.');
    }

    /**
     * Form edit (tambah siswa)
     */
    public function edit($id)
    {
        $pengajuan = PengajuanPklmagang::with('siswa')->findOrFail($id);
        return view('guru.pengajuan.edit', compact('pengajuan'));
    }

    /**
     * Tambah siswa manual
     */
    public function addSiswa(Request $request, $pengajuanId)
    {
        $request->validate([
            'nama_siswa' => 'required|string',
            'email_siswa' => 'required|email',
        ]);

        $pengajuan = PengajuanPklmagang::findOrFail($pengajuanId);

        // 🔒 Cegah duplikasi email siswa
        $exists = PengajuanPklSiswa::where('pengajuan_id', $pengajuan->id)
            ->where('email_siswa', $request->email_siswa)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Siswa dengan email ini sudah ditambahkan.');
        }

        PengajuanPklSiswa::create([
            'pengajuan_id' => $pengajuan->id,
            'nama_siswa' => $request->nama_siswa,
            'email_siswa' => $request->email_siswa,
            'status' => 'draft',
        ]);

        // 🔄 Sinkron jumlah siswa
        $pengajuan->update([
            'jumlah_siswa' => $pengajuan->siswa()->count()
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Submit pengajuan
     */
    public function submit($id)
    {
        $pengajuan = PengajuanPklmagang::with('siswa')->findOrFail($id);

        if ($pengajuan->siswa()->count() === 0) {
            return redirect()->back()
                ->with('error', 'Tambahkan minimal 1 siswa sebelum submit.');
        }

        DB::transaction(function () use ($pengajuan) {
            $pengajuan->update([
                'status' => 'diproses'
            ]);

            // hanya siswa valid yang diproses
            $pengajuan->siswa()
                ->whereNotNull('email_siswa')
                ->update(['status' => 'diproses']);
        });

        return redirect()
            ->route('guru.pengajuan.index')
            ->with('success', 'Pengajuan berhasil disubmit dan diproses admin.');
    }
}
