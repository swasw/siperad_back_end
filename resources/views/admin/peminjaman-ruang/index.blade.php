@extends('admin.partials.main');

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > {{ $title }}
                </li>
            </ol>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Berikut adalah {{ Str::lower($title) }} terupdate. </h6>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        {{ $title }}
                    </div>
                    <div>
                        <a href="{{ route('peminjaman-ruang.create') }}" class="btn btn-sm btn-primary">Tambah data</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl Peminjaman</th>
                                <th>Nama Peminjam</th>
                                <th>Mata Kuliah</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Nama Dosen</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>
                                <th>Ruangan</th>
                                <th>Status Peminjaman</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->tgl_peminjaman }}</td>
                                    <td>{{ $d->nama_peminjam }}</td>
                                    <td>{{ $d->matkul['mata_kuliah'] }}</td>
                                    <td>{{ substr($d->jamx['jam'], 0, 5) }}</td>
                                    <td>{{ substr($d->jamy['jam'], 0, 5) }}</td>
                                    <td>{{ $d->dosen['nama_dosen'] }}</td>
                                    <td>{{ $d->prodi['nama_prodi'] }}</td>
                                    <td>{{ $d->angkatan['angkatan'] }}</td>
                                    <td>{{ $d->ruang['nama_ruang'] }}</td>
                                    <td>
                                        @if ($d->status_peminjaman == 1)
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($d->status_peminjaman == 2)
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($d->status_peminjaman == 0)
                                            <form action="{{ route('peminjaman-ruang.status', $d->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status_peminjaman" value="1">
                                                <button type="submit" class="btn btn-sm btn-success" title="Setujui"><i class="fas fa-check"></i></button>
                                            </form>
                                            <form action="{{ route('peminjaman-ruang.status', $d->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status_peminjaman" value="2">
                                                <button type="submit" class="btn btn-sm btn-warning" title="Tolak"><i class="fas fa-times"></i></button>
                                            </form>
                                        @endif
                                        <a href="{{ route('peminjaman-ruang.destroy', $d->id) }}"
                                            class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                                class="fas fa-trash"></i></a>
                                        <a href="{{ route('peminjaman-ruang.edit', $d->id) }}"
                                            class="btn btn-sm btn-primary"><i class="fas fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
