@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > {{ $title }}
                </li>
            </ol>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Berikut adalah {{ Str::lower($title) }} terupdate. </h6>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        {{ $title }}
                    </div>
                    <div>
                        <a href="{{ route('dosen.create') }}" class="btn btn-sm btn-primary">Tambah data</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dosen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->nama_dosen }}</td>
                                    <td>
                                        @if ($d->kehadiran_dosen == '1')
                                            <span class="badge bg-success">
                                                available
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                non available
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('dosen.status') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="dosen_id" value="{{ $d->id }}">
                                            
                                            <button type="submit" class="btn btn-sm btn-info">
                                                <i
                                                    class="text-white fa-solid {{ $d->kehadiran_dosen == '1' ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('dosen.destroy', $d->id) }}" class="btn btn-sm btn-danger"
                                            data-confirm-delete="true">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="{{ route('dosen.edit', $d->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
