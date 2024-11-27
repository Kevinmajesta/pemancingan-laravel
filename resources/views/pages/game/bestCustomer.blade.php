@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pelanggan Terbaik</h4>
                        <p class="card-description">Berdasarkan perhitungan AHP</p>
                        
                        <form method="GET" action="{{ route('pages.game.bestCustomer') }}">
                            <div class="form-group">
                                <label for="month">Pilih Bulan:</label>
                                <select name="month" id="month" class="form-control">
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="year">Pilih Tahun:</label>
                                <select name="year" id="year" class="form-control">
                                    @foreach (range(date('Y') - 2, date('Y') + 2) as $year)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </form>

                        @if (isset($message))
                            <p class="mt-4">{{ $message }}</p>
                        @else
                            <h5 class="mt-4">Pelanggan Terbaik: {{ $bestCustomer->nickname ?? 'Unknown User' }}</h5>
                            <p>Skor AHP: {{ number_format($userScores[$bestCustomer->id] ?? 0, 2) }}</p>

                            <div class="table-responsive mt-4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nickname Pelanggan</th>
                                            <th>Skor AHP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($userScores as $userId => $score)
                                            <tr>
                                                <td>{{ \App\Models\User::find($userId)->nickname ?? 'Unknown User' }}</td>
                                                <td>{{ number_format($score, 2) }}</td>
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


{{-- 
@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pelanggan Terbaik</h4>
                        <p class="card-description">Berdasarkan perhitungan AHP</p>
                        
                        <form method="GET" action="#">
                            <div class="form-group">
                                <label for="month">Pilih Bulan:</label>
                                <select name="month" id="month" class="form-control">
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}">
                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </form>

                        {{-- Data dummy untuk tampilan --}}
                        {{-- <h5 class="mt-4">Pelanggan Terbaik: bigbro</h5>
                        <p>Skor AHP: 0.59</p>
                        

                        <div class="table-responsive mt-4">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nickname Pelanggan</th>
                                        <th>Skor AHP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>bigbro</td>
                                        <td>0.59</td>
                                    </tr>
                                    <tr>
                                        <td>sandal japit</td>
                                        <td>0.56</td>
                                    </tr>
                                    <tr>
                                        <td>sepatu</td>
                                        <td>0.51</td>
                                    </tr>
                                    <tr>
                                        <td>AKP</td>
                                        <td>0.49</td>
                                    </tr>
                                    <tr>
                                        <td>dedy</td>
                                        <td>0.27</td>
                                    </tr>
                                    <tr>
                                        <td>cihuy</td>
                                        <td>0.14</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}} 
