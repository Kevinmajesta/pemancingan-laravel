@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Riwayat Lomba Kolam Pemancingan</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scheduleModal">
                            Pilih Jadwal
                        </button>

                        <!-- Modal for schedule selection -->
                        <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog"
                            aria-labelledby="scheduleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="scheduleModalLabel">Pilih Jadwal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('games.indexUser') }}" method="GET">
                                            <div class="form-group">
                                                <label for="id_schedule">Jadwal</label>
                                                <select name="id_schedule" id="id_schedule" class="form-control" required>
                                                    <option value="">-- Pilih Jadwal --</option>
                                                    @foreach ($schedules as $schedule)
                                                        <option value="{{ $schedule->id_schedule }}">
                                                            {{ $schedule->activity_name }} -
                                                            {{ date('d-m-Y', strtotime($schedule->date)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Pilih</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (!empty($scheduleDetails))
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama User</th>
                                            <th>Ikan Terberat Sesi 1</th>
                                            <th>Ikan Terberat Sesi 2</th>
                                            <th>Ikan Terbanyak</th>
                                            <th>Pemenang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scheduleDetails as $scheduleDetail)
                                            <tr>
                                                <td>{{ optional($scheduleDetail->user)->name ?? 'N/A' }}</td>
                                                <td>{{ optional($scheduleDetail->game)->ikanterberat_sesi1 }}</td>
                                                <td>{{ optional($scheduleDetail->game)->ikanterberat_sesi2 }}</td>
                                                <td>{{ optional($scheduleDetail->game)->ikanterbanyak }}</td>
                                                <td>{{ optional($scheduleDetail->game)->pemenang }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">Tidak ada data riwayat lomba.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
