@extends('admin.partials.main')

@section('container')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-12">
                <div class="border border-success rounded px-3 pt-3 mb-4">
                    <h3 class="text-success mb-4">Selamat Datang, <b>Administrator</b></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <i class="fas fa-box me-1"></i>
                            History Peminjaman Alat
                        </div>
                        <div>
                            <a href="{{ route('peminjaman-barang.index') }}" class="btn btn-sm btn-primary">Akses</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Alat yang dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $b)
                                    <tr>
                                        <td>{{ $b->nama_peminjam }}</td>
                                        <td>{{ $b->tgl_peminjaman }}</td>
                                        <td>{{ $b->barang['nama_barang'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <i class="fas fa-house me-1"></i>
                            History Peminjaman Ruang
                        </div>
                        <div>
                            <a href="{{ route('peminjaman-ruang.index') }}" class="btn btn-sm btn-primary">Akses</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple1">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Ruang yang dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ruang as $r)
                                    <tr>
                                        <td>{{ $r->nama_peminjam }}</td>
                                        <td>{{ $r->tgl_peminjaman }}</td>
                                        <td>{{ $r->ruang['nama_ruang'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</main>
@endsection