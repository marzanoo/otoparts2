@extends('layouts.user_type.auth')

@section('title', 'Otoparts - Barang')

@section('content')
  <style>
    /* Gaya untuk modal latar belakang */
    .modal-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Transparan hitam */
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    /* Gaya untuk modal konten */
    .modal-content {
        background-color: #fff;
        border-radius: 8px;
        max-width: 680px;
        width: 90%;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Header modal */
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
    }

    /* Tombol tutup modal */
    .modal-header button {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
    }

    /* Animasi muncul modal */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
  </style>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="button-add">
            <button class="btn btn-primary" onclick="openModalTambah()"><i class="fa-solid fa-plus" style="margin-right: 10px"></i>Tambah</button>
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Tabel Barang</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Merek</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis Barang</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi Rak</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Beli</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Jual</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>                      
                      @php $index = 1; @endphp
                      @foreach($products as $row)
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $index++}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->brands->nama_merek}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->nama_barang}}</td>                      
                      <td class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ $row->jenis_barang}}</td>                      
                      <td class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ $row->stok}}</td>                      
                      <td class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ $row->lokasi_rak}}</td>                      
                      <td class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ $row->harga_beli}}</td>                      
                      <td class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">{{ $row->harga_jual}}</td>  
                      <td class="text-center">
                        <button class="btn btn-primary" onclick="openModalEdit({{ $row->id_barang }}, {{ $row->id_merek}}, '{{ $row->nama_barang}}', '{{ $row->jenis_barang}}', {{ $row->stok}}, {{ $row->lokasi_rak}}, {{ $row->harga_beli}}, {{ $row->harga_jual}})">Ubah</button>
                        <form action="{{ url('/delete-barang') . '/' . $row->id_barang }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin menghapus?')">Hapus</button>
                        </form>
                      </td>                                          
                    </tr>                      
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Tambah Data Barang -->
    <div class="modal-background" id="addModal">
      <div class="modal-content">
          <div class="modal-header">
              <h3>Tambah Data Barang</h3>
              <button onclick="closeModalTambah()">×</button>
          </div>
          <div class="modal-body">
              <form method="post" action="/add-barang">
                @csrf
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                        <label for="merek">Merek</label>
                        <select name="merek" class="form-control" required>
                          <option value="" hidden selected disabled>Pilih Merek</option>
                          @foreach($brands as $row)
                            <option value="{{ $row->id_merek}}">{{ $row->id_merek}} - {{ $row->nama_merek}}</option>
                          @endforeach
                        </select>                        
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_barang">Jenis Barang</label>
                        <input type="text" name="jenis_barang" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                  </div>        
                  <div class="col-6">
                    <div class="form-group">
                        <label for="lokasi_rak">Lokasi Rak</label>
                        <input type="number" name="lokasi_rak" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control" required>
                    </div>
                  </div>  
                </div>                                                   
                <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
              </form>
          </div>
      </div>
    </div>
    <!-- Modal Ubah Data Barang -->
    <div class="modal-background" id="editModal">
      <div class="modal-content">
          <div class="modal-header">
              <h3>Ubah Data Barang</h3>
              <button onclick="closeModalEdit()">×</button>
          </div>
          <div class="modal-body">
            <form method="post" action="#">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="merek">Merek</label>
                            <select name="merek" class="form-control" required>
                                <option value="" hidden disabled>Pilih Merek</option>
                                @foreach($brands as $row)
                                    <option value="{{ $row->id_merek }}">
                                        {{ $row->id_merek }} - {{ $row->nama_merek }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_barang">Jenis Barang</label>
                            <input type="text" name="jenis_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="lokasi_rak">Lokasi Rak</label>
                            <input type="number" name="lokasi_rak" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_beli">Harga Beli</label>
                            <input type="number" name="harga_beli" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
            </form>
          </div>        
      </div>
    </div>
  </main>
  <script>
    function openModalTambah() {
        document.getElementById("addModal").style.display = "flex";
    }

    function closeModalTambah() {
        document.getElementById("addModal").style.display = "none";
    }
    function openModalEdit(id_barang, id_merek, nama_barang, jenis_barang, stok, lokasi_rak, harga_beli, harga_jual) {
      document.getElementById('editModal').style.display = 'flex'; // Tampilkan modal
      document.querySelector('#editModal [name="merek"]').value = id_merek;
      document.querySelector('#editModal [name="nama_barang"]').value = nama_barang;
      document.querySelector('#editModal [name="jenis_barang"]').value = jenis_barang;
      document.querySelector('#editModal [name="stok"]').value = stok;
      document.querySelector('#editModal [name="lokasi_rak"]').value = lokasi_rak;
      document.querySelector('#editModal [name="harga_beli"]').value = harga_beli;
      document.querySelector('#editModal [name="harga_jual"]').value = harga_jual;
      document.querySelector('#editModal form').action = '/edit-barang/' + id_barang;
    }


    function closeModalEdit() {
        document.getElementById("editModal").style.display = "none";
    }
  </script>
  @endsection
