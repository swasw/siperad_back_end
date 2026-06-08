@extends('admin.partials.main')

@section('container')
    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet" />

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > <a
                        href="{{ route('jam.index') }}">Data Jam</a> > {{ $title }}</li>
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
                    <form action="{{ route('jam.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-2">
                            <label for="time">Jam</label>
                            <input type="time" class="form-control" id="appointment" name="jam" min="00:00"
                                max="23:00" required />
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
