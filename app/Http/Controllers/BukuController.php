<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BukuController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {

    $query = $request->input('q');

    if($query) {
        $allBuku = Buku::with('kategoris')->when($query, function($queryBuilder) use($query){
            $queryBuilder->where('judul', 'like', '%'. $query . '%')
                ->orWhere('pengarang', 'like', '%'. $query . '%')
                ->orWhere('tahun_terbit', 'like', '%'. $query . '%');
        })->paginate(10);
        $allBuku->appends(['q' => $query]);
    } else {
        $allBuku = Buku::with('kategoris')->latest()->paginate(5);
    }
        // $allBuku = Buku::all();%-33
        return view('buku.index', compact('allBuku'));
        // $totalBukus = Buku::count();
        // $totalStok = Buku::sum('stok');
    }

    /**
     * Show the form for creating a new resource.
     */
  public function create()
{
    $penerbit = Penerbit::all();
    $kategori = Kategori::all();
    return view('buku.create', compact('penerbit', 'kategori'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //buat validasi
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:100',
            'tahun_terbit' => 'required|integer',
            'kategori_ids' => 'required|array|min:1',
            'kategori_ids.*' => 'exists:kategoris,id',
            'penerbit_id' => 'required',
            'file_cover' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'deskripsi' => 'required',
            'stok' => 'required',
        ]);

        if ($request->hasFile('file_cover')) {
            $validatedData['cover'] = $request->file('file_cover')->store('cover', 'public');
        }
        unset($validatedData['file_cover'], $validatedData['kategori_ids']);

        $buku = Buku::create($validatedData);
        $buku->kategoris()->sync($request->kategori_ids);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambah.');
    }
        
    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'penerbit', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
   
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'pengarang' => 'required|max:100',
            'tahun_terbit' => 'required|integer',
            'kategori_ids' => 'required|array|min:1',
            'kategori_ids.*' => 'exists:kategoris,id',
            'penerbit_id' => 'required',
            'file_cover' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'deskripsi' => 'required',
            'stok' => 'required',
        ]);

        if ($request->hasFile('file_cover')) {
            $validatedData['cover'] = $request->file('file_cover')->store('cover', 'public');
            if ($request->cover_lama) {
                Storage::delete('public/' . $request->cover_lama);
            }
        }
        unset($validatedData['file_cover'], $validatedData['kategori_ids']);

        $buku->update($validatedData);
        $buku->kategoris()->sync($request->kategori_ids);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diubah.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        if($buku->cover && Storage::exists('public/' .$buku->cover)){
            Storage::delete('public/' . $buku->cover); 
        }
        $buku->delete();
         // redirect ke index buku
        return redirect()->route('buku.index');
    }

    public function count() 
    {
        $totalBuku     = Buku::count();        // jumlah data buku
        $totalKategori = Kategori::count();    // jumlah kategori
        $totalPenerbit = Penerbit::count();    // jumlah penerbit
        $totalUserAktif    = User::count();        // jumlah user

        return view('test', compact(
            'totalBuku',
            'totalKategori',
            'totalPenerbit',
            'totalUserAktif'
        ));
    }


}
