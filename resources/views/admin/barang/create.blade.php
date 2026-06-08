@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > <a
                        href="{{ route('barang.index') }}">Data Alat</a> > {{ $title }}</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Berikut adalah form {{ Str::lower($title) }}.</h6>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="alert-title">
                        <h4>Whoops!</h4>
                    </div>
                    There are some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    {{ $title }}
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-2">
                            <label for="nama_barang">Nama Alat</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                        </div>
                        <div class="form-group mb-2">
                            <label for="deskripsi_barang">Deskripsi Alat (<small
                                    class="form-text text-muted">Optional</small>)</label>
                            <textarea class="form-control" name="deskripsi_barang" id="deskripsi_barang" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="stok">Stok Alat (<small class="form-text text-muted">Satuan
                                    pcs</small>)</label>
                            <input type="number" class="form-control" name="stok" id="stok">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Status Alat</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_barang" id="tersedia"
                                    value="{{ 1 }}" checked>
                                <label class="form-check-label" for="tersedia">
                                    Tersedia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_barang" id="tidak_tersedia"
                                    value="{{ 0 }}">
                                <label class="form-check-label" for="tidak_tersedia">
                                    Tidak Tersedia
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
