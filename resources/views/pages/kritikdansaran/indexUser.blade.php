@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Kritik dan Saran</h4>
                        <p class="card-description">
                            Tuliskan semua kritik dan saran Anda
                        </p>

                        <!-- Tampilkan nama user yang sedang login -->
                        <div class="form-group">
                            <label for="userName">Nama Pengguna</label>
                            <input type="text" class="form-control" id="userName" value="{{ Auth::user()->name }}"
                                readonly>
                        </div>

                        <form class="forms-sample" method="POST" action="{{ route('pages.kritikdansaran.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail3">Tanggal</label>
                                <input type="date" class="form-control" name="date" placeholder="Tanggal">
                            </div>

                            <!-- Star Rating (5 stars) -->
                            <div class="form-group">
                                <label>Penilaian</label>
                                <div>
                                    <label>
                                        <input type="radio" name="rating" value="1"> 1
                                    </label>
                                    <label>
                                        <input type="radio" name="rating" value="2"> 2
                                    </label>
                                    <label>
                                        <input type="radio" name="rating" value="3"> 3
                                    </label>
                                    <label>
                                        <input type="radio" name="rating" value="4"> 4
                                    </label>
                                    <label>
                                        <input type="radio" name="rating" value="5"> 5
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleTextarea1">Komentar</label>
                                <textarea class="form-control" name="comment" rows="12"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Kritik dan Saran Anda</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Rating</th>
                                        <th>Komentar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kritik as $item)
                                        <tr>
                                            <td>{{ $item->user->name }}</td> <!-- Nama user -->
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->rating }}</td>
                                            <td>{{ $item->comment }}</td>
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
