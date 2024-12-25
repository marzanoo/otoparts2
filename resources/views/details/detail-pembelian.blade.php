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
          <div class="card mb-2">
            <div class="card-header pb-0">
                <h6>Detail Penjualan</h6>
                <button class="btn btn-secondary" onclick="window.location.href='{{ url('/pembelian') }}'">Kembali</button>
            </div>
            <div class="table-responsive pb-0">
                <table class="table align-items-center mb-0">
                    <tr>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">Id Pembelian</td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $purchases->id_pembelian}}</td>
                    </tr>
                    <tr>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">Tanggal</td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $purchases->tanggal}}</td>
                    </tr>
                    <tr>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">Total</td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $purchases->total}}</td>
                    </tr>
                    <tr>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">Distributor</td>
                        <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $purchases->id_distributor}}</td>
                    </tr>
                </table>
            </div>
          </div>  
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Tabel Detail Penjualan</h6>
              <button class="btn btn-primary" onclick="openModalTambah()"><i class="fa-solid fa-plus" style="margin-right: 10px"></i>Tambah</button>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Barang</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah</th>                      
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subtotal</th>                      
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>                      
                      @php $index = 1; @endphp
                      @foreach($purchasedetails as $row)
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">{{ $index++}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->products->nama_barang}}</td>
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->jumlah}}</td>                                            
                      <td class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">{{ $row->subtotal}}</td>                                            
                      <td class="text-center">
                        <form action="{{ url('/delete-purchase-details') . '/' . $row->id_pembelian . '/' . $row->id_barang }}" method="POST" style="display:inline;">
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
              <h3>Tambah Detail Penjualan</h3>
              <button onclick="closeModalTambah()">×</button>
          </div>
          <div class="modal-body">
              <form method="post" action="/add-purchase-details">
                @csrf
                <input type="hidden" name="id_pembelian" value="{{ $purchases->id_pembelian }}">
                <div class="form-group">
                    <label for="barang">Barang</label>
                    <select name="barang" id="barang" class="form-control" onchange="updateSubtotal()">
                        <option value="" hidden selected disabled>Pilih Barang</option>
                        @foreach ($products as $row)
                            <option value="{{ $row->id_barang }}" data-harga="{{ $row->harga_beli }}">{{ $row->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>                
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" id="jumlah" oninput="updateSubtotal()">
                </div>
                <div class="form-group">
                    <label for="subtotal">Subtotal</label>
                    <input name="subtotal" class="form-control" id="subtotal" readonly>
                </div>                                                                              
                <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
              </form>
          </div>
      </div>
    </div>   
    <!-- Modal Ubah Data -->
    {{-- <div class="modal-background" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Ubah Detail Penjualan</h3>
                <button onclick="closeModalEdit()">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formEdit">
                    @csrf
                    @method('PUT')
                    <!-- Sembunyikan id_penjualan dan id_barang -->
                    <input type="hidden" name="id_penjualan" id="editIdPenjualan">
                    <input type="hidden" name="id_barang" id="editIdBarang">
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="editJumlah" oninput="updateSubtotalEdit()" required>
                    </div>
                    <div class="form-group">
                        <label for="subtotal">Subtotal</label>
                        <input name="subtotal" class="form-control" id="editSubtotal" readonly>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div> --}}
  </main>
  <script>
    // function openModalEdit(id_penjualan, id_barang, jumlah, subtotal) {
    //     document.getElementById("editModal").style.display = "flex";

    //     // Set nilai id_penjualan, id_barang, dan jumlah pada form edit
    //     document.querySelector("#editIdPenjualan").value = id_penjualan;
    //     document.querySelector("#editIdBarang").value = id_barang;
    //     document.querySelector("#editJumlah").value = jumlah;
    //     document.querySelector("#editSubtotal").value = subtotal;

    //     // Update subtotal setelah mengubah jumlah
    //     updateSubtotalEdit();

    //     // Update action form dengan URL yang sesuai
    //     document.querySelector("#formEdit").action = "/edit-details/" + id_penjualan;
    // }

    // function updateSubtotalEdit() {
    //     const jumlah = document.getElementById('editJumlah').value;
    //     const hargaBarang = {{ $row->products ? $row->products->harga_jual : 0 }}; // Pastikan ini mengacu ke harga barang yang benar
    //     const subtotal = hargaBarang * jumlah;
    //     document.getElementById('editSubtotal').value = subtotal || 0;
    // }

    // function closeModalEdit() {
    //     document.getElementById("editModal").style.display = "none";
    // }


    function openModalTambah() {
        document.getElementById("addModal").style.display = "flex";
    }

    function closeModalTambah() {
        document.getElementById("addModal").style.display = "none";
    }
    function updateSubtotal() {
        const barang = document.getElementById('barang');
        const hargaBarang = barang.options[barang.selectedIndex].getAttribute('data-harga');
        const jumlah = document.getElementById('jumlah').value;
        const subtotal = hargaBarang * jumlah;
        document.getElementById('subtotal').value = subtotal || 0;
    }

  </script>
  @endsection
