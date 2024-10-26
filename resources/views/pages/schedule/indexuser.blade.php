@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Jadwal Anda</h4>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <a
                                                href="{{ route('pages.schedule.indexUser', ['sort' => 'activity_name', 'direction' => $sortField === 'activity_name' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
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
                                                href="{{ route('pages.schedule.indexUser', ['sort' => 'date', 'direction' => $sortField === 'date' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
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
                                                href="{{ route('pages.schedule.indexUser', ['sort' => 'time', 'direction' => $sortField === 'time' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
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
                                        <th>
                                            Maximal Quantity
                                        </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->activity_name }}</td>
                                            <td>{{ $schedule->date }}</td>
                                            <td>{{ $schedule->hours_remaining }}</td>
                                            <td>{{ $schedule->maxqty }} - ({{ $schedule->schedule_details_count }})</td>
                                            <!-- Updated line -->
                                            <td>
                                                <a href="{{ route('pages.schedule.daftarschedule.indexUser', $schedule->id_schedule) }}"
                                                    class="btn btn-sm btn-warning">Daftar</a>
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
