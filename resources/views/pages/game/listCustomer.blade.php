@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Pemenang per Tahun</h4>
                        <p class="card-description">Pemenang berdasarkan perhitungan AHP</p>

                        <form method="GET" action="{{ route('winners.list') }}">
                            <div class="form-group">
                                <label for="year">Pilih Tahun:</label>
                                <select name="year" id="year" class="form-control">
                                    @foreach (range(date('Y') - 2, date('Y') + 2) as $year)
                                        <option value="{{ $year }}" {{ request('year', date('Y')) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </form>

                        @if ($winners->isEmpty())
                            <p class="mt-4">Tidak ada pemenang untuk tahun ini.</p>
                        @else
                            <div class="table-responsive mt-4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Nickname Pemenang</th>
                                            <th>Skor AHP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($winners as $winner)
                                            <tr>
                                                <td>{{ $winner->month }}</td>
                                                <td>{{ $winner->user->nickname ?? 'Unknown User' }}</td>
                                                <td>{{ number_format($winner->score, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
