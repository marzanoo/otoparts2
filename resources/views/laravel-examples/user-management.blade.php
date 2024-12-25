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
<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Users</h5>
                        </div>
                        <button class="btn bg-gradient-primary btn-sm mb-0" onclick="openModalTambah()">+&nbsp; New User</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Username
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($users as $row)
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->id}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->username}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                            @if ( $row->role == 1)
                                                Owner
                                            @elseif ($row->role == 2)   
                                                Admin
                                            @elseif ( $row->role == 3)
                                                Kasir
                                            @endif
                                        </p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $row->created_at}}</span>
                                    </td>
                                    <td class="text-center">        
                                        <button class="btn mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user"><i class="fas fa-user-edit text-secondary"
                                            onclick="openModalEdit({{ $row->id }}, '{{ $row->name}}', '{{ $row->username}}', '{{ $row->password}}', {{ $row->role}})"></i></button>
                                        <span>
                                        <form action="{{ url('/delete-user') . '/' . $row->id }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" onclick="return confirm('Apakah anda yakin menghapus?')" data-bs-toggle="tooltip" data-bs-original-title="Hapus User"><i class="cursor-pointer fas fa-trash text-secondary"></i></button>
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
    <!-- Modal Tambah Data -->
    <div class="modal-background" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tambah Data User</h3>
                <button onclick="closeModalTambah()">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="/add-user">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>                        
                        <select name="role" id="" class="form-control" required>
                            <option value="" hidden selected disabled>Pilih Role...</option>
                            <option value="1">Owner</option>
                            <option value="2">Admin</option>
                            <option value="3">Kasir</option>
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
                <h3>Ubah Data User</h3>
                <button onclick="closeModalEdit()">×</button>
            </div>
            <div class="modal-body">
                <form method="post" action="#">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>                        
                        <select name="role" id="" class="form-control" required>
                            <option value="" hidden selected disabled>Pilih Role...</option>
                            <option value="1">Owner</option>
                            <option value="2">Admin</option>
                            <option value="3">Kasir</option>
                        </select>
                    </div>                                                              
                    <button type="submit" class="btn btn-secondary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openModalEdit(id, name, username, password, role) {
        document.getElementById("editModal").style.display = "flex";
        document.querySelector("#editModal [name=nama]").value = name;
        document.querySelector("#editModal [name=username]").value = username;
        document.querySelector("#editModal [name=role]").value = role;
        document.querySelector("#editModal form").action = '/edit-user/' + id ;
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