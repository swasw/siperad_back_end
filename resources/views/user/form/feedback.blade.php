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
        <div class="alert alert-danger mt-4">
            <div class="alert-title">
                <h4>Whoops!</h4>
            </div>
            Ada beberapa masalah dengan input Anda:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container py-5">
        <div class="content">
            <h5 class="mb-4">FEEDBACK</h5>
            <form action="{{ route('user.post.feedback') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="tgl_feedback" class="form-label">Tanggal</label>
                    <input type="text" id="tgl_feedback" name="tgl_feedback"
                        class="form-control" value="{{ now()->format('Y-m-d') }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama"
                        class="form-control" value="{{ auth()->user()->name }}">
                </div>

                <div class="mb-4">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select id="kategori" name="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Saran">Saran</option>
                        <option value="Keluhan">Keluhan</option>
                        <option value="Bug">Bug</option>
                        <option value="Pengalaman pengguna">Pengalaman pengguna</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="saran" class="form-label">Saran / Pesan</label>
                    <textarea id="saran" name="saran" class="form-control" rows="5" required>{{ old('saran') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Feedback</button>
            </form>
        </div>
    </div>
@stop
