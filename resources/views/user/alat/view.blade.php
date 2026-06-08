@extends('user.layouts.frontend')

@section('content')
    <main class="py-5 bg-light">
        <div class="container">
            {{-- Pesan Peringatan --}}
            <div class="alert alert-warning shadow-sm">
                <h5 class="mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Perhatian!</h5>
                <ul class="mb-0">
                    <li>Peminjaman alat hanya dapat dilakukan <strong>di hari yang sama</strong>.</li>
                    <li>Setelah mengisi form peminjaman, segera ambil alat di <strong>ruangan admin prodi</strong>.</li>
                    <li>Jangan lupa <strong>serahkan KTM Anda</strong> kepada admin prodi saat mengambil alat.</li>
                    <li>Setelah selesai menggunakan, <strong>kembalikan alat dan ambil kembali KTM Anda</strong> ke admin prodi.</li>
                </ul>
            </div>

            <div class="text-center mb-4">
                <h3 class="fw-bold">Ketersediaan Alat</h3>
                <p class="text-muted">Berikut adalah daftar alat yang tersedia untuk dipinjam</p>
            </div>

            <div class="row">
                @forelse ($data as $alat)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $alat->nama_barang }}</h5>
                                <p class="card-text">
                                    <strong>Deskripsi Alat:</strong> {{ $alat->deskripsi_barang }}<br>
                                    <strong>Stok:</strong>
                                    <span>
                                        {{ $alat->stok > 0 ? $alat->stok . ' Tersedia' : 'Habis' }}
                                    </span>
                                </p>
                            </div>
                            <div class="card-footer bg-white text-end">
                                @if ($alat->stok > 0 && $alat->status_barang == '1')
                                    <a href="{{ route('user.formpeminjamanalat', ['alat_id' => $alat->id]) }}"
                                        class="btn btn-sm btn-primary">
                                        Pinjam Sekarang
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        @if ($alat->status_barang == '0' && $alat->stok > 0)
                                            Sedang Rusak
                                        @elseif ($alat->stok == 0)
                                            Tidak Tersedia
                                        @endif
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Tidak ada data alat yang tersedia saat ini.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
