@extends('user.layouts.frontend')

@section('content')
    <main class="py-4">
        <div class="container">
            {{-- Pesan Peringatan --}}
            <div class="alert alert-warning shadow-sm">
                <h5 class="mb-2"><i class="bi bi-info-circle-fill"></i> Perhatian!</h5>
                <ul class="mb-0">
                    <li>Sebelum melakukan peminjaman ruangan, <strong>periksa terlebih dahulu jadwal kelas</strong> melalui
                        menu <strong>Jadwal Kelas</strong> untuk mengetahui ruangan yang tersedia.</li>
                    <li>Setelah itu, buka menu <strong>Ketersediaan Ruangan</strong>.</li>
                    <li>Gunakan fitur <strong>Filter Ruangan</strong> dan pilih tanggal sesuai kebutuhan Anda.</li>
                    <li>Periksa jam yang tersedia, lalu <strong>klik atau drag pada jam yang diinginkan</strong> untuk
                        menampilkan form peminjaman. Jika ruangan telah terisi pada jam tersebut, silakan pilih ruangan atau
                        jam lain yang masih kosong.</li>
                </ul>
            </div>
            <h3 class="text-center mb-4">Kalender Jadwal Ruangan</h3>
            <form method="GET" class="mb-3 text-center">
                <label for="filterRuang" class="me-2">Pilih Ruangan:</label>
                <select name="ruang" id="filterRuang" onchange="this.form.submit()" class="form-select d-inline w-auto">
                    <option value="">Semua Ruangan</option>
                    @foreach ($ruanganList as $r)
                        <option value="{{ $r->nama_ruang }}" {{ request('ruang') == $r->nama_ruang ? 'selected' : '' }}>
                            {{ $r->nama_ruang }}
                        </option>
                    @endforeach
                </select>
            </form>
            <div id='calendar'></div>
        </div>

        <!-- Modal Form -->
        <div class="modal" id="peminjamanModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Form Peminjaman</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <form action="{{ route('user.peminjaman-ruang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="text" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control"
                                    readonly value="{{ old('tgl_peminjaman') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Peminjam</label>
                                <input type="text" name="nama_peminjam" class="form-control"
                                    value="{{ old('nama_peminjam', auth()->user()->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="matkul_id">Mata Kuliah</label>
                                <select class="form-select" name="matkul_id">
                                    <option selected disabled>Mata Kuliah</option>
                                    @foreach ($matkul as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('matkul_id') == $m->id ? 'selected' : '' }}>{{ $m->mata_kuliah }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="time">Jam Mulai</label>
                                <select class="form-select" name="jam_mulai_id">
                                    <option selected disabled>Jam Mulai</option>
                                    @foreach ($jam_mulai as $jm)
                                        <option value="{{ $jm->id }}"
                                            {{ old('jam_mulai_id') == $jm->id ? 'selected' : '' }}>
                                            {{ substr($jm->jam, 0, 5) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="time">Jam Selesai</label>
                                <select class="form-select" name="jam_selesai_id" required>
                                    <option selected disabled>Jam Selesai</option>
                                    @foreach ($jam_selesai as $js)
                                        <option value="{{ $js->id }}"
                                            {{ old('jam_selesai_id') == $js->id ? 'selected' : '' }}>
                                            {{ substr($js->jam, 0, 5) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dosen_id">Nama Dosen</label>
                                <select class="form-select" name="dosen_id" required>
                                    <option selected disabled>Nama Dosen</option>
                                    @foreach ($dosen as $nd)
                                        <option value="{{ $nd->id }}"
                                            {{ old('dosen_id') == $nd->id ? 'selected' : '' }}>{{ $nd->nama_dosen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="prodi_id" class="form-label">Prodi</label>
                                <select class="form-select" name="prodi_id" required>
                                    <option selected disabled>Pilih Prodi</option>
                                    @foreach ($prodi as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('prodi_id', auth()->user()->prodi_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan_id">Angkatan</label>
                                <select class="form-select" name="angkatan_id">
                                    <option selected disabled>Pilih Angkatan</option>
                                    @foreach ($angkatan as $a)
                                        <option value="{{ $a->id }}"
                                            {{ old('angkatan_id', auth()->user()->angkatan_id) == $a->id ? 'selected' : '' }}>
                                            {{ $a->angkatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ruang_id" class="form-label">Ruangan</label>
                                <select class="form-select" name="ruang_id" {{ request('ruang') ? 'disabled' : '' }}>
                                    <option selected disabled>Pilih Ruangan</option>
                                    @foreach ($ruang as $r)
                                        <option value="{{ $r->id }}"
                                            {{ old('ruang_id', optional($ruang->firstWhere('nama_ruang', request('ruang')))->id) == $r->id ? 'selected' : '' }}>
                                            {{ $r->nama_ruang }}
                                        </option>
                                    @endforeach
                                </select>

                                @if (request('ruang'))
                                    @php
                                        $selectedRuang = $ruang->firstWhere('nama_ruang', request('ruang'));
                                    @endphp
                                    <input type="hidden" name="ruang_id"
                                        value="{{ old('ruang_id', $selectedRuang->id ?? '') }}">
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ajukan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FullCalendar & Bootstrap Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Calendar Logic -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: @json($events),
                    dateClick: function(info) {
                        calendar.changeView('timeGridDay', info.dateStr);
                    },
                    eventClick: function(info) {
                        const date = new Date(info.event.start);
                        const dateStr = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2,
                            '0') + '-' + String(date.getDate()).padStart(2, '0');
                        document.getElementById('tgl_peminjaman').value = dateStr;

                        if (info.event.title === 'Kosong') {
                            const modal = new bootstrap.Modal(document.getElementById('peminjamanModal'));
                            modal.show();
                        } else {
                            alert("Slot ini sudah terisi jadwal!");
                        }
                    },
                    selectable: true,
                    select: function(info) {
                        const start = new Date(info.start);
                        const end = new Date(info.end);

                        const dateStr = start.getFullYear() + '-' +
                            String(start.getMonth() + 1).padStart(2, '0') + '-' +
                            String(start.getDate()).padStart(2, '0');

                        document.getElementById('tgl_peminjaman').value = dateStr;

                        setSelectOptionByText(document.querySelector('select[name="jam_mulai_id"]'), start
                            .toTimeString().substring(0, 5));
                        setSelectOptionByText(document.querySelector('select[name="jam_selesai_id"]'), end
                            .toTimeString().substring(0, 5));

                        const modal = new bootstrap.Modal(document.getElementById('peminjamanModal'));
                        modal.show();
                    },
                    eventDidMount: function(info) {
                        if (info.event.title.startsWith('Matkul Pengganti')) {
                            info.el.style.backgroundColor = '#dc3545';
                        }
                    },
                    slotMinTime: "00:00:00",
                    slotMaxTime: "24:00:00",
                    slotDuration: "01:00:00",
                    allDaySlot: false,

                    slotLabelFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false,
                        meridiem: false,
                        omitZeroMinute: false,
                        separator: '.' // ini penting untuk 08.00
                    },
                });

                calendar.render();

                function setSelectOptionByText(select, text) {
                    for (let i = 0; i < select.options.length; i++) {
                        if (select.options[i].text.trim() === text.trim()) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                }
            });
        </script>

        <style>
            #calendar {
                max-width: 1000px;
                margin: 0 auto;
            }
        </style>

        <!-- Alerts & Modal Show Logic -->
        @if (session('alert'))
            <script>
                window.addEventListener('load', function() {
                    Swal.fire({
                        title: '{{ session('alert.title') }}',
                        text: '{{ session('alert.text') }}',
                        icon: '{{ session('alert.icon') }}',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                window.addEventListener('load', function() {
                    Swal.fire({
                        title: 'Oops!',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        const modal = new bootstrap.Modal(document.getElementById('peminjamanModal'));
                        modal.show();
                    });
                });
            </script>
        @endif
    </main>
@endsection
