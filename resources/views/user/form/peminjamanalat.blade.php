@extends('user.layouts.frontend')

@section('content')
    @if (session('alert'))
        <script>
            Swal.fire({
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.text') }}',
                icon: '{{ session('alert.icon') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
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
    <div class="container">
        <div class="content pt-4 pt-lg-0">
            </br></br>
            <h5>FORM PEMINJAMAN ALAT</h5>
            </br>
            <form action="{{ route('user.peminjaman-alat.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="tgl_peminjaman" class="form-control" value="{{ date('Y-m-d') }}"
                        min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" class="form-control" id=""
                        value="{{ auth()->user()->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">NIM Peminjam</label>
                    <input type="text" name="nim" class="form-control" id=""
                        value="{{ auth()->user()->username }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Hp</label>
                    <input type="text" name="no_hp" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="prodi_id" class="form-label">Prodi</label>
                    <select class="form-select" name="prodi_id" required>
                        <option selected disabled>Pilih Prodi</option>
                        @foreach ($prodi as $p)
                            <option value="{{ $p->id }} " @if (auth()->user()->prodi_id == $p->id) selected @endif>
                                {{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="angkatan_id">Angkatan</label>
                    <select class="form-select" name="angkatan_id">
                        <option selected disabled>Pilih Angkatan</option>
                        @foreach ($angkatan as $a)
                            <option value="{{ $a->id }}" @if (auth()->user()->angkatan_id == $a->id) selected @endif>
                                {{ $a->angkatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="matkul_id">Mata Kuliah</label>
                    <select class="form-select" name="matkul_id">
                        <option selected disabled>Mata Kuliah</option>
                        @foreach ($matkul as $m)
                            <option value="{{ $m->id }}">{{ $m->mata_kuliah }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dosen_id">Nama Dosen</label>
                    <select class="form-select" name="dosen_id">
                        <option selected disabled>Nama Dosen</option>
                        @foreach ($dosen as $nd)
                            <option value="{{ $nd->id }}">{{ $nd->nama_dosen }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="barang_id" class="form-label">Nama Alat</label>
                    <input type="text" class="form-control" value="{{ $barang->nama_barang }}" disabled>
                    <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                </div>

                {{-- <div class="mb-3">
                    <input type="hidden" name="status_peminjaman" value="Sedang diajukan" class="form-control"
                        id="">
                </div> --}}
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </form>
    </div>
    </div>
@stop
