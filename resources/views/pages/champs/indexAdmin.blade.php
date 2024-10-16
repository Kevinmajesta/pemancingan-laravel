@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pilih Pemenang</h4>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('pages.champs.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Nama Pemenang</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Pilih Pemenang</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
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
                            <label for="weight">Berat</label>
                            <input type="number" name="weight" id="weight" class="form-control" required>
                            @error('weight')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Pilih Pemenang</button>
                    </form>

                    <h4 class="mt-4">Daftar Pemenang</h4>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Berat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($champs as $champ)
                                    <tr>
                                        <td>{{ $champ->user->name }}</td>
                                        <td>{{ $champ->date }}</td>
                                        <td>{{ $champ->weight }}</td>
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
