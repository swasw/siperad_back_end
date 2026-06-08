@extends('layouts.frontend')
@section('content')
@if(session('berhasil'))
    <div class="alert alert-success" role="alert">
    {{session('berhasil')}}
    </div>
@endif
<div class="container">
  <div class="content pt-4 pt-lg-0">
</br></br>
        <h5>FORM PEMINJAMAN RUANG</h5>
        </br>
        <form action="{{ route('user.peminjaman-ruang.store') }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="mb-3">
                <label class="form-label">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">NIM Peminjam</label>
                <input type="text" name="nim_peminjam" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">Nomo Hp</label>
                <input type="text" name="no_hp" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" id=""></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email_peminjam" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Peminjaman</label>
                <input type="date" name="tgl_peminjaman" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Pengembalian</label>
                <input type="date" name="tgl_pengembalian" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Ruang</label>
                <input type="text" name="jumlah_ruang" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <input type="hidden" name="status_peminjaman" value="Sedang diajukan" class="form-control" id="" >
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Scan KTM</label>
                <input type="file" name="ktm" class="form-control" >
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Surat Peminjaman</label>
                <input type="file" name="surat_peminjaman" class="form-control" >
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </div>
        </form>
    </div>
</div>
@stop

