@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > <a
                        href="{{ route('angkatan.index') }}">Data Angkatan</a> > {{ $title }}</li>
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
                    <form action="{{ route('angkatan.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            {{-- <label for="id">Kode Barang</label> --}}
                            <input type="hidden" class="form-control" name="id" id="id"
                                value="{{ $data->id }}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="angkatan">Angkatan</label>
                            <input type="text" class="form-control" name="angkatan" value="{{ $data->angkatan }}"
                                id="angkatan" required>
                        </div>
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>

        </div>
    </main>
@endsection
