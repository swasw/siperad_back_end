@extends('user.layouts.frontend')

@section('content')
    <div class="container">
        <div class="content pt-4 pt-lg-0">
            </br></br>
            <h3 class="panel-title text-center mb-4">Data Peminjaman Alat</h3>

            {{-- Form Pencarian --}}
            <div class="row justify-content-end mb-3">
                <div class="col-md-6 col-12">
                    <form class="d-flex flex-column flex-sm-row gap-2" method="GET"
                        action="{{ route('user.historypeminjamanalat') }}">
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
                            <th>NIM</th>
                            <th>No HP</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                            <th>Matkul</th>
                            <th>Dosen</th>
                            <th>Barang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $peminjamanalat)
                            <tr>
                                <td>{{ $peminjamanalat->tgl_peminjaman }}</td>
                                <td>{{ $peminjamanalat->nama_peminjam }}</td>
                                <td>{{ $peminjamanalat->nim }}</td>
                                <td>{{ $peminjamanalat->no_hp }}</td>
                                <td>{{ $peminjamanalat->prodi['nama_prodi'] }}</td>
                                <td>{{ $peminjamanalat->angkatan['angkatan'] }}</td>
                                <td>{{ $peminjamanalat->matkul['mata_kuliah'] }}</td>
                                <td>{{ $peminjamanalat->dosen['nama_dosen'] }}</td>
                                <td>{{ $peminjamanalat->barang['nama_barang'] }}</td>
                                <td class="text-center">
                                    @if ($peminjamanalat->status_peminjaman == 1)
                                        <span class="badge bg-success">Sudah dikembalikan</span>
                                    @else
                                        <span class="badge bg-secondary">Belum dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
