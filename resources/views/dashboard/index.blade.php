@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Selamat Datang</h3>
                        <h6 class="font-weight-normal mb-0">di Kolam R&Y Fishing Kuala Kapuas </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people mt-auto">
                        <img src="{{ asset('assets/images/dashboard/rb_35102.png') }}" alt="people">
                        <div class="weather-info">
                            <div class="d-flex">
                                <div>
                                    <h2 class="mb-1 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                                </div>
                                <div class="ml-2">
                                    <h4 class="location font-weight-normal">Kuala Kapuas</h4>
                                    <h6 class="font-weight-normal">Kalimantan Tengah</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Current Time</p>
                                <p class="fs-30 mb-2" id="current-time">Loading...</p>
                                <p id="current-date" style="font-size: 13px;">Loading date...</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Games</p>
                                <p class="fs-30 mb-2">61344</p>
                                <p>22.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Schedules</p>
                                <p class="fs-30 mb-2">61344</p>
                                <p>22.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Games</p>
                                <p class="fs-30 mb-2">61344</p>
                                <p>22.00% (30 days)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Tentang</p>
                        <p class="font-weight-500">
                            Pemancingan kolam R&Y Fishing, yang berdiri sejak Agustus 2020, telah memasuki usia 4 tahun dan
                            hingga kini sudah lebih dari 100 pemancing yang merasakan pengalaman memancing di tempat ini.
                        </p>
                        <img src="{{ asset('assets/images/dashboard/rb_2151199745.png') }}" class="img-fluid w-90" alt="R&Y Fishing">

                            </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="card-title">Informasi</p>
                               
                            </div>
                            <p class="font-weight-500">No Information Yet.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2"
                                data-ride="carousel">
                                <div class="carousel-inner">
                                    <!-- Slide 1 -->
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <!-- Gambar -->
                                            <div class="col-md-7 d-flex align-items-center">
                                                <img src="{{ asset('assets/images/dashboard/WhatsApp Image 2024-08-30 at 22.22.43_3a570ba8.jpg') }}"
                                                    alt="people" class="img-fluid rounded">
                                            </div>
                                            <!-- Garis Pembatas -->
                                            <div class="col-md-1 d-flex align-items-center">
                                                <div class="border-right w-75"
                                                    style="height: 100%; border-right-width: 10px;">
                                                </div>
                                            </div>

                                            <!-- Tulisan -->
                                            <div class="col-md-4 d-flex align-items-center">
                                                <div>
                                                    <h3 class="text-primary">Informasi Gambar</h3>
                                                    <p class="mb-2">Ini adalah deskripsi untuk gambar pertama. Anda dapat
                                                        menambahkan teks yang relevan di sini sesuai kebutuhan.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Slide 2 -->
                                    <div class="carousel-item">
                                        <div class="row">
                                            <!-- Gambar -->
                                            <div class="col-md-7 d-flex align-items-center">
                                                <img src="{{ asset('assets/images/dashboard/WhatsApp Image 2024-08-30 at 22.22.43_93d70d51.jpg') }}"
                                                    alt="people" class="img-fluid rounded">
                                            </div>
                                            <!-- Garis Pembatas -->
                                            <div class="col-md-1 d-flex align-items-center">
                                                <div class="border-right w-75"
                                                    style="height: 100%; border-right-width: 4px;">
                                                </div>
                                            </div>

                                            <!-- Tulisan -->
                                            <div class="col-md-4 d-flex align-items-center">
                                                <div>
                                                    <h3 class="text-primary">Informasi Gambar</h3>
                                                    <p class="mb-2">Ini adalah deskripsi untuk gambar kedua. Anda dapat
                                                        menambahkan teks yang relevan di sini sesuai kebutuhan.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Navigasi Carousel -->
                                <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#detailedReports" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Map R&Y Fishing Kuala Kapuas</p>
                            <!-- Elemen untuk peta -->
                            <div id="map" class="rounded-lg" style="height: 400px;"></div>

                        </div>
                    </div>
                </div>
            </div>



            <script>
                // Fungsi untuk menginisialisasi peta
                function initializeMap() {
                    // Membuat peta dan mengatur koordinat awal (contoh: R&Y Pemancingan, Kuala Kapuas)
                    const map = L.map('map').setView([-2.975118, 114.404916], 16);

                    // Menambahkan layer OpenStreetMap ke peta
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    // Menambahkan marker (titik lokasi) ke peta
                    L.marker([-2.975118, 114.404916]).addTo(map)
                        .bindPopup("Lokasi: R&Y Pemancingan, Kuala Kapuas, Kalimantan Tengah")
                        .openPopup();
                }

                // Panggil fungsi untuk pertama kali saat halaman dimuat
                initializeMap();
            </script>


            <script>
                function updateDateTime() {
                    const now = new Date();

                    // Format waktu
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    const timeString = `${hours}:${minutes}:${seconds}`;

                    // Format tanggal
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    const dateString = now.toLocaleDateString('en-US', options); // Ubah 'en-US' sesuai lokal Anda, seperti 'id-ID'

                    // Update elemen HTML
                    document.getElementById("current-time").textContent = timeString;
                    document.getElementById("current-date").textContent = dateString;
                }

                // Update waktu dan tanggal setiap detik
                setInterval(updateDateTime, 1000);

                // Panggil fungsi untuk pertama kali saat halaman dimuat
                updateDateTime();
            </script>
        @endsection
