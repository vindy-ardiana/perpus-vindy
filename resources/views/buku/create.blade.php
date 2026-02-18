@include('layout.header')
        <h3>Buat Buku</h3>
        <form action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
            @csrf 
            <div class="form-group">
                <label for="">Judul Buku:</label>
                <input type="text" name="judul" id="" placeholder="Masukan judul buku">
            </div>
            <div class="form-group">
                <label for="">Pengarang:</label>
                <input type="text" name="pengarang" id="" placeholder="Masukan nama pengarang">
            </div>
            <div class="form-group">
                <label for="">Tahun Terbit:</label>
                <input type="text" name="tahun_terbit" id="" placeholder="Masukan tahun terbit">
            </div>

             <div class="form-group">
                <label for="">Deskripsi:</label>
                <input type="text" name="deskripsi" id="" placeholder="Masukan deskripsi">
            </div>

             <div class="form-group">
                <label for="">Stok:</label>
                <input type="number" name="stok" id="" placeholder="Masukan stok">
            </div>

            <div class="form-group">
                <label for="">Penerbit:</label>
                <select name="penerbit_id" id="">
                    @foreach($penerbit as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_penerbit }}</option>
                    @endforeach
                </select>
            </div>

             <div class="form-group">
                <label for="">Kategori:</label>
                <select name="kategori_id" id="">
                    @foreach($kategori as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-froup">
                <label for="">Gambar Sampul:
                    <input type="file" name="file_cover" id="">
                </label>
            </div>
            <button type="submit" class="tombol">Submit</button>
        </form>
        
   
    @include('layout.footer')