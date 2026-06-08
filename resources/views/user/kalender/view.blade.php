@extends('user.layouts.frontend')

@section('content')
    <main>
        <div class="container-fluid px-4 pt-4 pt-lg-5">
            {{-- Filter Form --}}
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="hari" class="form-label">Hari</label>
                                <select name="hari" id="hari" class="form-select">
                                    <option value="">-- Pilih Hari --</option>
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $h)
                                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>
                                            {{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('user.lihatjadwal') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Jadwal Header --}}
            <div class="card mb-3 text-center">
                <div class="card-body py-3">
                    <h5 class="mb-0">
                        Jadwal Hari <strong>{{ ucfirst(request('hari') ?? 'Senin') }}</strong>
                    </h5>
                </div>
            </div>

            {{-- Jadwal Table --}}
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center align-middle">
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
