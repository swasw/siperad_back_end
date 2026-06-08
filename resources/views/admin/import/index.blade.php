@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Input Multiple Data</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > Input Multiple Data
                </li>
            </ol>
            
            @if (session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- Card Download Template -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-download me-1"></i>
                            Download Template Excel
                        </div>
                        <div class="card-body">
                            <p>Unduh template berformat CSV (bisa dibuka melalui Excel) di bawah ini sesuai dengan data yang ingin di-import.</p>
                            <a href="{{ route('import.template.angkatan') }}" class="btn btn-outline-success w-100 mb-2">
                                <i class="fas fa-file-excel"></i> Template Angkatan
                            </a>
                            <a href="{{ route('import.template.barang') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-file-excel"></i> Template Alat/Barang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card Form Import -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-upload me-1"></i>
                            Upload Data
                        </div>
                        <div class="card-body">
                            <form id="importForm" action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="dataType" class="form-label">Tipe Data</label>
                                    <select class="form-select" id="dataType" name="type" required onchange="updateFormAction()">
                                        <option value="" disabled selected>-- Pilih Tipe Data --</option>
                                        <option value="angkatan">Data Angkatan</option>
                                        <option value="barang">Data Alat/Barang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Pilih File (CSV/Excel)</label>
                                    <input class="form-control" type="file" id="file" name="file" accept=".csv, .xlsx, .xls" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane"></i> Submit Import
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        function updateFormAction() {
            var type = document.getElementById('dataType').value;
            var form = document.getElementById('importForm');
            if (type === 'angkatan') {
                form.action = "{{ route('import.angkatan') }}";
            } else if (type === 'barang') {
                form.action = "{{ route('import.barang') }}";
            }
        }
    </script>
@endsection
