<?php

namespace App\Http\Controllers;

use App\Models\DaftarJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaftarJasaController extends Controller
{
    public function index()
    {
        $kategoris = [
            'Teknologi',
            'Rumah Tangga',
            'Pendidikan',
            'Kesehatan',
            'Kecantikan',
            'Transportasi',
            'Otomotif',
            'Makanan',
            'Olahraga',
            'Lainnya'
        ];

        if (auth()->user()->hasRole('admin')) {
            $jasas = \App\Models\DaftarJasa::latest()->get();
            return view('daftar_jasa.index', compact('jasas', 'kategoris'));
        } elseif (auth()->user()->hasRole('user')) {
            return view('daftar_jasa.index', compact('kategoris'));
        }

        return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
    }



    /**
     * Show the form for creating a new resource (tidak digunakan).
     */
    public function create()
    {
        return redirect()->route('daftar_jasa.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if (!auth()->user()->hasRole('user')) {
        return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
    }

    $request->validate([
        'nama_jasa' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'kategori'  => 'required|string|max:255',
        'lokasi'    => 'required|string|max:255',
        'harga'     => 'required|numeric|min:0',
        'kontak'    => 'required|string|max:255',
        'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = [
        'user_id'     => auth()->id(),
        'nama'        => $request->nama_jasa,
        'email'       => auth()->user()->email,
        'telepon'     => $request->kontak,
        'jenis_jasa'  => $request->kategori,
        'deskripsi'   => $request->deskripsi,
        'alamat'      => $request->lokasi,
        'budget'      => $request->harga,
    ];

    if ($request->hasFile('gambar')) {
        $data['foto'] = $request->file('gambar')->store('daftar_jasa-foto', 'public');
    }

    DaftarJasa::create($data);

    return redirect()->route('daftar_jasa.index')
                     ->with('success', 'Pengajuan jasa berhasil dikirim!');
}



    /**
     * Display the specified resource.
     */
    public function show(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Mark as read when viewed
        if (!$daftar_jasa->is_read) {
            $daftar_jasa->update(['is_read' => true]);
        }

        return view('daftar_jasa.show', compact('daftar_jasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        return view('daftar_jasa.edit', compact('daftar_jasa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_jasa', 'deskripsi', 'kategori', 'harga', 'lokasi', 'kontak']);
        
        if ($request->hasFile('gambar')) {
            // Delete old photo if exists
            if ($daftar_jasa->gambar) {
                Storage::disk('public')->delete($daftar_jasa->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('daftar_jasa-gambars', 'public');
        }

        $daftar_jasa->update($data);

        return redirect()->route('daftar_jasa.index')
                         ->with('success', 'Jasa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        // Delete photo if exists
        if ($daftar_jasa->gambar) {
            Storage::disk('public')->delete($daftar_jasa->gambar);
        }

        $daftar_jasa->delete();

        return redirect()->route('daftar_jasa.index')
                         ->with('success', 'Jasa berhasil dihapus!');
    }

    public function markAsRead(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $daftar_jasa->update(['is_read' => true]);

        return redirect()->route('daftar_jasa.index')
                         ->with('success', 'Jasa telah ditandai sebagai sudah dibaca!');
    }

    public function destroyGambar(DaftarJasa $daftar_jasa)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        if ($daftar_jasa->gambar) {
            Storage::disk('public')->delete($daftar_jasa->gambar);
            $daftar_jasa->update(['gambar' => null]);
        }

        return redirect()->back()
                         ->with('success', 'Gambar berhasil dihapus!');
    }
}