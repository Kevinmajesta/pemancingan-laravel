@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambah Jadwal</h4>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('pages.schedule.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="activity_name">Nama Aktivitas</label>
                                <input type="text" name="activity_name" id="activity_name" class="form-control" required>
                                @error('activity_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="maxqty">Max Qty</label>
                                <input type="number" name="maxqty" id="maxqty" class="form-control" required>
                                @error('maxqty')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date">Tanggal</label>
                                <input type="date" name="date" id="date" class="form-control" required>
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="time">Waktu</label>
                                <input type="time" name="time" id="time" class="form-control" required>
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
                        </form>

                        <h4 class="mt-4">Daftar Jadwal</h4>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <a
                                                href="{{ route('pages.schedule.indexAdmin', ['sort' => 'activity_name', 'direction' => $sortField === 'activity_name' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Aktivitas
                                                @if ($sortField === 'activity_name')
                                                    @if ($sortDirection === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a
                                                href="{{ route('pages.schedule.indexAdmin', ['sort' => 'date', 'direction' => $sortField === 'date' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Tanggal
                                                @if ($sortField === 'date')
                                                    @if ($sortDirection === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>

                                        <th>
                                            <a
                                                href="{{ route('pages.schedule.indexAdmin', ['sort' => 'time', 'direction' => $sortField === 'time' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Waktu
                                                @if ($sortField === 'time')
                                                    @if ($sortDirection === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->activity_name }}</td>
                                            <td>{{ $schedule->date }}</td>
                                            <td>{{ $schedule->time }}</td>
                                            <td>{{ $schedule->maxqty }}</td>
                                            <td>
                                                <a href="{{ route('pages.schedule.edit', $schedule->id_schedule) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <a href="{{ route('games.index') }}" class="btn btn-sm btn-done">Hasil</a>
                                                <form
                                                    action="{{ route('pages.schedule.destroy', $schedule->id_schedule) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm justify-content-center">
                                    {{ $schedules->links('vendor.pagination.bootstrap-4') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
