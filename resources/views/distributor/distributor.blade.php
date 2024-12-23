@extends('layouts.user_type.auth')

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
        max-width: 600px;
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
              <h6>Tabel Distributor</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>                      
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>                      
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>                      
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>                      
                      @php $index = 1; @endphp
                      @foreach($distributors as $row)
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $index++}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->nama_distributor}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->alamat}}</td>                                            
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->kontak}}</td>                                            
                      <td class="text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->email}}</td>                                            
                      <td class="text-center">
                        <button class="btn btn-primary" onclick="openModalEdit({{ $row->id_distributor}}, '{{ $row->nama_distributor}}', '{{ $row->alamat}}', '{{ $row->kontak}}', '{{ $row->email}}')">Ubah</button>                      
                        <form action="{{ url('/delete-distributor') . '/' . $row->id_distributor }}" method="POST" style="display:inline;">
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
    <!-- Modal Tambah Data -->
    <div class="modal-background" id="addModal">
      <div class="modal-content">
          <div class="modal-header">
              <h3>Tambah Data Distributor</h3>
              <button onclick="closeModalTambah()">×</button>
          </div>
          <div class="modal-body">
              <form method="post" action="/add-distributor">
                @csrf
                <div class="form-group">
                    <label for="nama_distributor">Nama Distributor</label>
                    <input type="text" name="nama_distributor" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>                                                 
                <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
              </form>
          </div>
      </div>
    </div>
    <!-- Modal Ubah Data -->
    <div class="modal-background" id="editModal">
      <div class="modal-content">
          <div class="modal-header">
              <h3>Ubah Data Distributor</h3>
              <button onclick="closeModalEdit()">×</button>
          </div>
          <div class="modal-body">
              <form method="post" action="/edit-distributor">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_distributor">Nama Distributor</label>
                    <input type="text" name="nama_distributor" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
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
    function openModalEdit(id_distributor, nama_distributor, alamat, kontak, email) {
        document.getElementById("editModal").style.display = "flex";
        document.querySelector('#editModal [name=nama_distributor]').value = nama_distributor;
        document.querySelector('#editModal [name=alamat]').value = alamat;
        document.querySelector('#editModal [name=kontak]').value = kontak;
        document.querySelector('#editModal [name=email]').value = email;
        document.querySelector('#editModal form').action = '/edit-distributor/' + id_distributor;
    }

    function closeModalTambah() {
        document.getElementById("editModal").style.display = "none";
    }
  </script>
  @endsection