@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Semua Pemenang</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
              <tr>
                                        <th>
                                            <a href="{{ route('pages.champs.indexAdmin', ['sort' => 'user_id', 'direction' => $sortField === 'user_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Nama 
                                                @if ($sortField === 'user_id')
                                                    @if ($sortDirection === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('pages.champs.indexAdmin', ['sort' => 'date', 'direction' => $sortField === 'date' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
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
                                            <a href="{{ route('pages.champs.indexAdmin', ['sort' => 'weight', 'direction' => $sortField === 'weight' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                                Berat 
                                                @if ($sortField === 'weight')
                                                    @if ($sortDirection === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($champs as $item)
                                        <tr>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->weight }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Kontrol pagination -->
                        <div class="mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm justify-content-center">
                                    {{ $champs->links('vendor.pagination.bootstrap-4') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
