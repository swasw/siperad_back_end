@extends('user.layouts.frontend')

@section('content')
<main class="py-4">
    <div class="container">
        <h3 class="text-center mb-3">Availability of Lecturer</h3>

        @php
            $chunks = $data->chunk(ceil($data->count() / 2)); // Bagi jadi 2 kolom sama rata
        @endphp

        <div class="row">
            @foreach ($chunks as $column)
                <div class="col-md-6">
                    @foreach ($column as $index => $lecturer)
                        <div class="lecturer-box {{ $lecturer->kehadiran_dosen == '1' ? 'bg-success' : 'bg-danger' }} text-white mb-2">
                             {{ $lecturer->nama_dosen }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .lecturer-box {
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</main>
@endsection
