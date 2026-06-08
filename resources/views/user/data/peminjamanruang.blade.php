@extends('user.layouts.frontend')

@section('content')
    <div class="container">
        <div class="content pt-4 pt-lg-0">
            <h3 class="panel-title text-center mb-4">Data Peminjaman Ruang</h3>

            {{-- Form Pencarian --}}
            <div class="row justify-content-end mb-3">
                <div class="col-md-6 col-12">
                    <form class="d-flex flex-column flex-sm-row gap-2" method="GET"
                        action="{{ route('user.historypeminjamanruang') }}">
                        <input class="form-control" name="cari" type="text" placeholder="Cari Nama/NIM..."
                            value="{{ request('cari') }}">
                        <button class="btn btn-outline-primary" type="submit">Cari</button>
                    </form>
                </div>
            </div>

            {{-- Tabel Responsif --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Matkul</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Dosen</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                            <th>Ruang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $peminjamanruang)
                            <tr>
                                <td>{{ $peminjamanruang->tgl_peminjaman }}</td>
                                <td>{{ $peminjamanruang->nama_peminjam }}</td>
                                <td>{{ $peminjamanruang->matkul['mata_kuliah'] }}</td>
                                <td>{{ substr($peminjamanruang->jamx['jam'], 0, 5) }}</td>
                                <td>{{ substr($peminjamanruang->jamy['jam'], 0, 5) }}</td>
                                <td>{{ $peminjamanruang->dosen['nama_dosen'] }}</td>
                                <td>{{ $peminjamanruang->prodi['nama_prodi'] }}</td>
                                <td>{{ $peminjamanruang->angkatan['angkatan'] }}</td>
                                <td>{{ $peminjamanruang->ruang['nama_ruang'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Optional: Pagination --}}
            {{-- <div class="d-flex justify-content-center mt-3">
                {{ $data->links() }}
            </div> --}}
        </div>
    </div>
@endsection
