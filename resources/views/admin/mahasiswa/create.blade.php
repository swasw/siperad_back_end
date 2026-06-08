@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > <a
                        href="{{ route('mahasiswa.index') }}">Data Mahasiswa</a> > {{ $title }}</li>
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
                    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-2">
                            <label for="nama_mahasiswa">Nama Mahasiswa</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group mb-2">
                            <label for="username">NIM</label>
                            <input type="text" class="form-control" name="username" id="username">
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group mb-2">
                            <label for="prodi_id">Prodi</label>
                            <select class="form-select" name="prodi_id">
                                <option selected disabled>Pilih Prodi</option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="angkatan_id">Angkatan</label>
                            <select class="form-select" name="angkatan_id">
                                <option selected disabled>Pilih Angkatan</option>
                                @foreach ($angkatan as $a)
                                    <option value="{{ $a->id }}">{{ $a->angkatan }}</option>
                                @endforeach
                            </select>
                        </div>


                        <input type="hidden" class="form-control" name="type" value="0">


                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
