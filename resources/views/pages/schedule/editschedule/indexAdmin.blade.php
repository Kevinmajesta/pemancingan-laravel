@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Jadwal</h4>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('pages.schedule.update', $schedule->id_schedule) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="activity_name">Nama Aktivitas</label>
                                <input type="text" name="activity_name" id="activity_name" class="form-control" required value="{{ old('activity_name', $schedule->activity_name) }}">
                                @error('activity_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="maxqty">Max Qty</label>
                                <input type="number" name="maxqty" id="maxqty" class="form-control" required value="{{ old('maxqty', $schedule->maxqty) }}">
                                @error('maxqty')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date">Tanggal</label>
                                <input type="date" name="date" id="date" class="form-control" required value="{{ old('date', $schedule->date) }}">
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="time">Waktu</label>
                                <input type="time" name="time" id="time" class="form-control" required value="{{ old('time', $schedule->time) }}">
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update Jadwal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
