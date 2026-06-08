@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > {{ $title }}
                </li>
            </ol>

            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <select name="hari" class="form-select">
                            <option value="">-- Pilih Hari --</option>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>
                                    {{ $h }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="ruang" class="form-select">
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach ($ruanganList as $r)
                                <option value="{{ $r }}" {{ request('ruang') == $r ? 'selected' : '' }}>
                                    {{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('jadwal-ruangan.view') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="card mb-4 text-center">
                <div class="card-body">
                    <h6>
                        Jadwal Hari {{ request('hari') ? ucfirst(request('hari')) : 'Senin' }}
                    </h6>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>RUANG</th>
                                @foreach ($jamHeaders as $jam)
                                    <th>{{ $jam }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruanganList as $ruang)
                                <tr>
                                    <td><strong>{{ $ruang }}</strong></td>
                                    @php
                                        $jamList = $jamHeaders;
                                        $slots = $matrix[$ruang] ?? [];
                                        $colIndex = 0;
                                    @endphp

                                    @while ($colIndex < count($jamList))
                                        @php
                                            $currentJam = $jamList[$colIndex];
                                            $currentContent = $slots[$currentJam] ?? '-';
                                        @endphp

                                        @if ($currentContent === '-' || empty($currentContent))
                                            {{-- Tampilkan "-" satu per satu --}}
                                            <td>-</td>
                                            @php $colIndex++; @endphp
                                        @else
                                            {{-- Hitung colspan jika isi sama dan bukan kosong --}}
                                            @php
                                                $colspan = 1;
                                                for ($j = $colIndex + 1; $j < count($jamList); $j++) {
                                                    $nextJam = $jamList[$j];
                                                    $nextContent = $slots[$nextJam] ?? '-';
                                                    if ($nextContent === $currentContent) {
                                                        $colspan++;
                                                    } else {
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            <td colspan="{{ $colspan }}">{!! $currentContent !!}</td>
                                            @php $colIndex += $colspan; @endphp
                                        @endif
                                    @endwhile
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
