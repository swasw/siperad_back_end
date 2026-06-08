@extends('admin.partials.main');

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > <a
                        href="{{ route('jadwal-ruangan.index') }}">Data Jadwal Ruangan</a> > {{ $title }}</li>
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
                    <form action="{{ route('jadwal-ruangan.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="ruang_id">Nama Ruang</label>
                            <select class="form-select" name="ruang_id">
                                <option selected value="{{ $data->ruang['id'] }}">Nama Ruang terpilih :
                                    {{ $data->ruang['nama_ruang'] }} </option>
                                @foreach ($ruang as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_ruang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="matkul_id">Mata Kuliah</label>
                            <select class="form-select" name="matkul_id">
                                <option selected value="{{ $data->matkul['id'] }}">Mata Kuliah terpilih :
                                    {{ $data->matkul['mata_kuliah'] }} </option>
                                @foreach ($matkul as $m)
                                    <option value="{{ $m->id }}">{{ $m->mata_kuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="dosen_id">Nama Dosen</label>
                            <select class="form-select" name="dosen_id">
                                <option selected value="{{ $data->dosen['id'] }}">Nama Dosen terpilih :
                                    {{ $data->dosen['nama_dosen'] }} </option>
                                @foreach ($dosen as $nd)
                                    <option value="{{ $nd->id }}">{{ $nd->nama_dosen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label for="hari">Hari</label>
                            <select name="hari" data-placeholder="Pilih Hari" class="form-select form-select-solid">
                                <option value="senin" <?php if ($data->hari == 'senin') {
                                    echo 'selected';
                                } ?>>Senin</option>
                                <option value="selasa" <?php if ($data->hari == 'selasa') {
                                    echo 'selected';
                                } ?>>Selasa</option>
                                <option value="rabu" <?php if ($data->hari == 'rabu') {
                                    echo 'selected';
                                } ?>>Rabu</option>
                                <option value="kamis" <?php if ($data->hari == 'kamis') {
                                    echo 'selected';
                                } ?>>Kamis</option>
                                <option value="jumat" <?php if ($data->hari == 'jumat') {
                                    echo 'selected';
                                } ?>>Jumat</option>
                                <option value="sabtu" <?php if ($data->hari == 'sabtu') {
                                    echo 'selected';
                                } ?>>Sabtu</option>
                                <option value="minggu" <?php if ($data->hari == 'minggu') {
                                    echo 'selected';
                                } ?>>Minggu</option>


                            </select>
                        </div>


                        <div class="form-group mb-2">
                            <label for="jam_mulai_id">Jam Mulai</label>
                            <select class="form-select" name="jam_mulai_id">
                                <option selected value="{{ $data->jamx['id'] }}">Jam Mulai terpilih :
                                    {{ substr($data->jamx['jam'], 0, 5) }} </option>
                                @foreach ($jam as $jm)
                                    <option value="{{ $jm->id }}">{{ substr($jm->jam, 0, 5) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="jam_selesai_id">Jam Selesai</label>
                            <select class="form-select" name="jam_selesai_id">
                                <option selected value="{{ $data->jamy['id'] }}">Jam Selesai terpilih :
                                    {{ substr($data->jamy['jam'], 0, 5) }} </option>
                                @foreach ($jam as $js)
                                    <option value="{{ $js->id }}">{{ substr($js->jam, 0, 5) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="prodi_id">Prodi</label>
                            <select class="form-select" name="prodi_id">
                                <option selected value="{{ $data->prodi['id'] }}">Prodi terpilih :
                                    {{ $data->prodi['nama_prodi'] }} </option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="angkatan_id">Angkatan</label>
                            <select class="form-select" name="angkatan_id">
                                <option selected value="{{ $data->angkatan['id'] }}">Angkatan terpilih :
                                    {{ $data->angkatan['angkatan'] }}</option>
                                @foreach ($angkatan as $a)
                                    <option value="{{ $a->id }}">{{ $a->angkatan }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group mb-2">
                            <label for="">Status Ruang</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_ruang" id="tersedia"
                                    value="{{ 1 }}" {{ $data->status_ruang == 1 ? 'Checked' : '' }}>
                                <label class="form-check-label" for="tersedia">
                                    Tersedia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_ruang" id="tidak_tersedia"
                                    value="{{ 0 }}" {{ $data->status_ruang == 0 ? 'Checked' : '' }}>
                                <label class="form-check-label" for="tidak_tersedia">
                                    Tidak Tersedia
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
