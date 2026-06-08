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
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Berikut adalah {{ Str::lower($title) }} terupdate. </h6>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        {{ $title }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('jadwal-ruangan.create') }}" class="btn btn-sm btn-primary">Tambah data</a>

                        <form action="{{ route('jadwal-ruangan.destroyall') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data?');" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus Semua</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ruang</th>
                                <th>Mata Kuliah</th>
                                <th>Nama Dosen</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Status Ruang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->ruang['nama_ruang'] }}</td>
                                    <td>{{ $d->matkul['mata_kuliah'] }}</td>
                                    <td>{{ $d->dosen['nama_dosen'] }}</td>
                                    <td>{{ $d->prodi['nama_prodi'] }}</td>
                                    <td>{{ $d->angkatan['angkatan'] }}</td>
                                    <td>{{ $d->hari }}</td>
                                    <td>{{ substr($d->jamx['jam'], 0, 5) }}</td>
                                    <td>{{ substr($d->jamy['jam'], 0, 5) }}</td>
                                    <td>
                                        @if ($d->status_ruang == 1)
                                            <button class="btn btn-sm btn-success" disabled>Tersedia</button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Tidak Tersedia</button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('jadwal-ruangan.destroy', $d->id) }}"
                                            class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                                class="fas fa-trash"></i></a>
                                        <a href="{{ route('jadwal-ruangan.edit', $d->id) }}"
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
