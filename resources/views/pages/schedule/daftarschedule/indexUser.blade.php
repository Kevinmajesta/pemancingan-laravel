@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar untuk Jadwal: {{ $schedule->activity_name }}</h4>

                        <!-- Display messages -->
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- Registration Form -->
                        <form action="{{ route('schedule_detail.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_schedule" value="{{ $schedule->id_schedule }}">
                            <div class="form-group">
                                <label for="id_schedule">ID Jadwal</label>
                                <input type="text" name="id_schedule" id="id_schedule" class="form-control" value="{{ $schedule->id_schedule }}" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </form>

                        <hr>

                        <!-- Registered Users List -->
                        <h4 class="mt-4">Daftar Pendaftaran Jadwal</h4>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th>Tanggal Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($scheduleDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->user->name }}</td>
                                            <td>{{ $detail->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
