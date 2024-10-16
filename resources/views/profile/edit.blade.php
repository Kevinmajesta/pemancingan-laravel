@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Profil Pengguna</h4>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Bagian Update Informasi Profil -->
                    <div class="mt-4">
                        <h5 class="text-primary">Update Informasi Profil</h5>
                        <div class="card p-4 bg-light shadow-sm rounded">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Bagian Update Password -->
                    <div class="mt-4">
                        <h5 class="text-primary">Update Password</h5>
                        <div class="card p-4 bg-light shadow-sm rounded">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Bagian Hapus Akun -->
                    <div class="mt-4">
                        <h5 class="text-danger">Hapus Akun</h5>
                        <div class="card p-4 bg-light shadow-sm rounded">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
