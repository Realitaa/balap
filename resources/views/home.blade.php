<x-app-layout>
    <x-slot:page>Home</x-slot:page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="container py-4">
        <!-- Judul -->
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Halo, {{ Auth::user()->name }}!</h1>

        <div class="row">
            <!-- Informasi Pengguna -->
            <div class="col-lg-8">
                <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                    <div class="row mb-2">
                        <div class="col-4 font-bold">Nama</div>
                        <div class="col-8">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-bold">Email</div>
                        <div class="col-8">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-bold">Tanggal Lahir</div>
                        <div class="col-8">{{ \Carbon\Carbon::parse(Auth::user()->birthdate)->locale('id')->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-bold">Alamat</div>
                        <div class="col-8">{{ Auth::user()->address }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-bold">Kota</div>
                        <div class="col-8">{{ Auth::user()->city }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-bold">Masa Berlaku Hingga</div>
                        <div class="col-8">{{ \Carbon\Carbon::parse(Auth::user()->expired_date)->locale('id')->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Logo -->
            <div class="col-lg-4 text-center">
                <img src="{{ asset('img/logo.png') }}" alt="IMI Logo" class="img-fluid img-thumbnail transition-transform hover:scale-105" style="max-width: 300px;">
            </div>
        </div>

        <!-- Tombol Cetak Kartu -->
        <div class="mt-4">
            <a class="btn btn-primary btn-lg transition-colors hover:bg-blue-600"
            @if (!Auth::user()->birthdate || !Auth::user()->address || !Auth::user()->city)
                data-bs-toggle="modal" data-bs-target="#warningModal"
            @else
                href="{{ route('print') }}"
            @endif
            >
                <i class="bi bi-printer me-2"></i> Cetak Kartu
            </a>
        </div>
    </div>

    <!-- Modal Peringatan -->
    @if (!Auth::user()->birthdate || !Auth::user()->address || !Auth::user()->city)
        <x-modal id="warningModal" title="Lengkapi Data Anda" dialog-class="modal-dialog-centered">
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Maaf, Anda harus melengkapi data sebelum mendapatkan kartu Anda.
            </div>
            @slot('actionButton')
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('profile') }}" class="btn btn-primary">Lengkapi Data</a>
            @endslot
        </x-modal>
    @endif
</x-app-layout>