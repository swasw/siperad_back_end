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
                    <form action="{{ route('mahasiswa.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            {{-- <label for="id">Kode Barang</label> --}}
                            <input type="hidden" class="form-control" name="id" id="id"
                                value="{{ $data->id }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="name">Nama Mahasiswa</label>
                            <input type="text" class="form-control" name="name" value="{{ $data->name }}"
                                id="name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="username">NIM</label>
                            <input type="text" class="form-control" name="username" value="{{ $data->username }}"
                                id="username" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="prodi_id">Prodi</label>
                            <select class="form-select" name="prodi_id">
                                <option selected value="{{ $data->prodi['id'] }}">Prodi terpilih :
                                    {{ $data->prodi['nama_prodi'] }} </option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="angkatan_id">Angkatan</label>
                            <select class="form-select" name="angkatan_id">
                                <option selected value="{{ $data->angkatan['id'] }}">Angkatan terpilih :
                                    {{ $data->angkatan['angkatan'] }}</option>
                                @foreach ($angkatan as $a)
                                    <option value="{{ $a->id }}">{{ $a->angkatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
