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
              <h6>Tabel Penjualan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>                      
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Distributor</th>                      
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detail</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>                      
                      @php $index = 1; @endphp
                      @foreach($purchases as $row)
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $index++}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->tanggal}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->total}}</td>                                            
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->distributors->nama_distributor}}</td>                                            
                      <td class="text-center">
                        <button class="btn btn-secondary" onclick="window.location.href='{{ url('/purchase-details') . '/' . $row->id_pembelian }}'">Detail</button>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-primary" onclick="openModalEdit({{ $row->id_pembelian}}, '{{ $row->tanggal}}', '{{ $row->total}}', '{{ $row->id_distributor}}')">Ubah</button>
                        <form action="{{ url('/delete-pembelian') . '/' . $row->id_pembelian }}" method="POST" style="display:inline;">
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
              <h3>Tambah Data Penjualan</h3>
              <button onclick="closeModalTambah()">×</button>
          </div>
          <div class="modal-body">
              <form method="post" action="/add-pembelian">
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="number" name="total" class="form-control" id="total" readonly>
                </div>                                                 
                <div class="form-group">
                  <label for="distributor">Distributor</label>
                  <select name="distributor" class="form-control" id="">
                      <option value="" hidden selected disabled>Pilih Distributor</option>
                      @foreach ($distributors as $row)            
                        <option value="{{ $row->id_distributor }}">{{ $row->nama_distributor }}</option>                          
                      @endforeach
                  </select>
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
              <h3>Ubah Data Pembelian</h3>
              <button onclick="closeModalEdit()">×</button>
          </div>
          <div class="modal-body">
              <form method="post" action="#">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="total">Total</label>
                  <input type="number" name="total" class="form-control" id="total" readonly>
                </div>         
                <div class="form-group">
                  <label for="distributor">Distributor</label>
                  <select name="distributor" class="form-control" id="">
                    @foreach ($distributors as $row)            
                      <option value="{{ $row->id_distributor }}">{{ $row->nama_distributor }}</option>                          
                    @endforeach
                  </select>
                </div>                                                 
                <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
              </form>
          </div>
      </div>
    </div>
  </main>
  <script>
    function openModalEdit(id_pembelian, tanggal, total, id_distributor) {
        document.getElementById("editModal").style.display = "flex";
        document.querySelector("#editModal [name=tanggal]").value = tanggal;
        document.querySelector("#editModal [name=total]").value = total;
        document.querySelector("#editModal [name=distributor]").value = id_distributor;
        document.querySelector("#editModal form").action = '/edit-pembelian/' + id_pembelian ;
    }

    function closeModalEdit() {
        document.getElementById("editModal").style.display = "none";
    }
    function openModalTambah() {
        document.getElementById("addModal").style.display = "flex";
    }

    function closeModalTambah() {
        document.getElementById("addModal").style.display = "none";
    }
  </script>
  @endsection
