<x-app-layout>
    <x-slot:header><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"></x-slot:header>
    <x-slot:page>Profil</x-slot:page>

    <div class="container">
        <h1>Profil {{ Auth::user()->name }}</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->hasBag('updatePassword'))
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->getBag('updatePassword')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <div class="card border-primary">
            <div class="card-body">
                <h4 class="card-title">Informasi Dasar</h4>
                <form action="{{ route('update.basic') }}" method="post">
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name" placeholder="Nama Kamu" value="{{ Auth::user()->name }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email Kamu" value="{{ Auth::user()->email }}" required />
                        <small id="emailHelp" class="form-text text-muted">Ini adalah email yang digunakan untuk login.</small>
                    </div>
                    <button class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>

        <div class="card border-primary mt-3">
            <div class="card-body">
                <h4 class="card-title">Informasi Tambahan</h4>
                <form action="{{ route('update.additional') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" name="birthdate" id="birthdate" aria-describedby="birthdate" placeholder="Tanggal Lahir Kamu" value="{{ old('birthdate', Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('d-m-Y') : '') }}" />
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat Kamu">{{ old('address', Auth::user()->address) }}</textarea> 
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="city" id="city" aria-describedby="city" placeholder="Kota Kamu" value="{{ old('city', Auth::user()->city) }}" />
                    </div>
                    <button class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>

        <div class="card border-warning my-3">
            <div class="card-body">
                <h4 class="card-title">Keamanan</h4>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" name="current_password" id="current_password" aria-describedby="currentPassword" placeholder="Password Lama Kamu"/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password" id="password" aria-describedby="newPassword" placeholder="Password Baru Kamu"/>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Ulangi Password Baru</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" aria-describedby="confirmPassword" placeholder="Konfirmasi Password Baru Kamu"/>
                    </div>
                    <button class="btn btn-warning">Ganti Password Saya</button>
                </form>
            </div>
        </div>

        <div class="card border-danger my-3">
            <div class="card-body">
                <h4>Hapus Akun</h4>
                <p>Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#suicideModal">Hapus Akun</button>
            </div>
        </div>
    </div>    
    
    <!-- Modal Body -->
    <div class="modal fade" id="suicideModal" tabindex="-1" role="dialog" aria-labelledby="suicideModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content border border-danger border-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="suicideModal">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dikembalikan.
                    <br> Masukkan password Anda untuk mengonfirmasi.</div>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                        <div class="m-3">
                            <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password" />
                        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">Ya, hapus akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("suicideModal"),
            options,
        );
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#birthdate", {
            dateFormat: "d-m-Y",
            defaultDate: "{{ Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('d-m-Y') : '' }}"
        });
    </script>
</x-app-layout>
