@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Hasil Lomba Kolam Pemancingan</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <!-- Add a form to filter by id_schedule -->
                        <form action="{{ route('games.index') }}" method="GET">
                            <div class="form-group">
                                <label for="id_schedule">Pilih Jadwal</label>
                                <select name="id_schedule" id="id_schedule" class="form-control"
                                    onchange="this.form.submit()">
                                    <option value="">-- Pilih Jadwal --</option>
                                    @foreach ($schedules as $schedule)
                                        <option value="{{ $schedule->id_schedule }}"
                                            {{ $selectedSchedule == $schedule->id_schedule ? 'selected' : '' }}>
                                            {{ $schedule->activity_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        @if (!empty($scheduleDetails))
                            <form action="{{ route('games.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_schedule" value="{{ $selectedSchedule }}">
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
                                                    <td>
                                                        @if ($scheduleDetail->user)
                                                            {{ $scheduleDetail->user->name }}
                                                            <!-- Automatically display user name -->
                                                        @else
                                                            N/A
                                                        @endif
                                                        <input type="hidden" name="id_schedule_detail[]"
                                                            value="{{ $scheduleDetail->id_schedule_detail }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="ikanterberat_sesi1[]"
                                                            class="form-control"
                                                            value="{{ optional($scheduleDetail->game)->ikanterberat_sesi1 }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="ikanterberat_sesi2[]"
                                                            class="form-control"
                                                            value="{{ optional($scheduleDetail->game)->ikanterberat_sesi2 }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="ikanterbanyak[]" class="form-control"
                                                            value="{{ optional($scheduleDetail->game)->ikanterbanyak }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="pemenang[]" class="form-control"
                                                            value="{{ optional($scheduleDetail->game)->pemenang }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Simpan Hasil</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
