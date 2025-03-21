<x-app-layout>
    <x-slot:header><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"></x-slot:header>
    <x-slot:page>Profil</x-slot:page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="container py-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Profil {{ Auth::user()->name }}</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->hasBag('updatePassword'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <ul class="mb-0">
                    @foreach ($errors->getBag('updatePassword')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Informasi Dasar -->
        <div class="card border-primary shadow-md rounded-lg mb-4">
            <div class="card-body p-4">
                <h4 class="card-title text-xl font-semibold text-primary mb-3">Informasi Dasar</h4>
                <form action="{{ route('update.basic') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label font-medium text-gray-700">Nama</label>
                        <input type="text" class="form-control border-gray-300 focus:ring-primary focus:border-primary" name="name" id="name" aria-describedby="name" placeholder="Nama Kamu" value="{{ Auth::user()->name }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label font-medium text-gray-700">Email</label>
                        <input type="email" class="form-control border-gray-300 focus:ring-primary focus:border-primary" name="email" id="email" aria-describedby="emailHelp" placeholder="Email Kamu" value="{{ Auth::user()->email }}" required />
                        <small id="emailHelp" class="form-text text-muted">Ini adalah email yang digunakan untuk login.</small>
                    </div>
                    <button class="btn btn-primary transition-colors hover:bg-blue-600">Kirim</button>
                </form>
            </div>
        </div>

        <!-- Informasi Tambahan -->
        <div class="card border-primary shadow-md rounded-lg mb-4">
            <div class="card-body p-4">
                <h4 class="card-title text-xl font-semibold text-primary mb-3">Informasi Tambahan</h4>
                <form action="{{ route('update.additional') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="birthdate" class="form-label font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="text" class="form-control border-gray-300 focus:ring-primary focus:border-primary" name="birthdate" id="birthdate" aria-describedby="birthdate" placeholder="Tanggal Lahir Kamu" value="{{ old('birthdate', Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('d-m-Y') : '') }}" />
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label font-medium text-gray-700">Alamat</label>
                        <textarea class="form-control border-gray-300 focus:ring-primary focus:border-primary" name="address" id="address" rows="3" placeholder="Alamat Kamu">{{ old('address', Auth::user()->address) }}</textarea> 
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label font-medium text-gray-700">Kota</label>
                        <input type="text" class="form-control border-gray-300 focus:ring-primary focus:border-primary" name="city" id="city" aria-describedby="city" placeholder="Kota Kamu" value="{{ old('city', Auth::user()->city) }}" />
                    </div>
                    <button class="btn btn-primary transition-colors hover:bg-blue-600">Kirim</button>
                </form>
            </div>
        </div>

        <!-- Keamanan -->
        <div class="card border-warning shadow-md rounded-lg mb-4">
            <div class="card-body p-4">
                <h4 class="card-title text-xl font-semibold text-warning mb-3">Keamanan</h4>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="current_password" class="form-label font-medium text-gray-700">Password Saat Ini</label>
                        <input type="password" class="form-control border-gray-300 focus:ring-warning focus:border-warning" name="current_password" id="current_password" aria-describedby="currentPassword" placeholder="Password Lama Kamu"/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label font-medium text-gray-700">Password Baru</label>
                        <input type="password" class="form-control border-gray-300 focus:ring-warning focus:border-warning" name="password" id="password" aria-describedby="newPassword" placeholder="Password Baru Kamu"/>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label font-medium text-gray-700">Ulangi Password Baru</label>
                        <input type="password" class="form-control border-gray-300 focus:ring-warning focus:border-warning" name="password_confirmation" id="password_confirmation" aria-describedby="confirmPassword" placeholder="Konfirmasi Password Baru Kamu"/>
                    </div>
                    <button class="btn btn-warning transition-colors hover:bg-yellow-600">Ganti Password Saya</button>
                </form>
            </div>
        </div>

        <!-- Hapus Akun -->
        <div class="card border-danger shadow-md rounded-lg mb-4">
            <div class="card-body p-4">
                <h4 class="text-xl font-semibold text-danger mb-3">Hapus Akun</h4>
                <p class="text-gray-700">Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
                <button class="btn btn-danger transition-colors hover:bg-red-700" data-bs-toggle="modal" data-bs-target="#suicideModal">Hapus Akun</button>
            </div>
        </div>
    </div>    
    
    <!-- Modal Hapus Akun -->
    <div class="modal fade" id="suicideModal" tabindex="-1" role="dialog" aria-labelledby="suicideModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content border border-danger border-3 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="suicideModal">Hapus Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-gray-700">Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dikembalikan.</p>
                    <p class="text-gray-700">Masukkan password Anda untuk mengonfirmasi.</p>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-0">
                        @csrf
                        @method('delete')
                        <div class="mb-3">
                            <input type="password" class="form-control border-gray-300 focus:ring-danger focus:border-danger" name="password" id="password" aria-describedby="helpId" placeholder="Password" />
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger transition-colors hover:bg-red-700">Ya, hapus akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#birthdate", {
            dateFormat: "d-m-Y",
            defaultDate: "{{ Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('d-m-Y') : '' }}"
        });
    </script>
</x-app-layout>