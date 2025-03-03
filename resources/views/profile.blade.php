<x-app-layout>
    <x-slot:header><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"></x-slot:header>
    <x-slot:page>Profile</x-slot:page>

    <div class="container">
        <h1>Profil {{ Auth::user()->name }}</h1>
        <div class="card border-primary">
            <div class="card-body">
                <h4 class="card-title">Informasi Dasar</h4>
                <form action="" method="post">
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
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" name="birthdate" id="birthdate" aria-describedby="birthdate" placeholder="Tanggal Lahir Kamu" />
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat Kamu" {{ Auth::user()->address ?? '' }}></textarea> 
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="city" id="city" aria-describedby="city" placeholder="Kota Kamu" {{ Auth::user()->city ?? '' }} />
                    </div>
                    <button class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>

        <div class="card border-primary my-3">
            <div class="card-body">
                <h4 class="card-title">Keamanan</h4>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" name="currentPassword" id="currentPassword" aria-describedby="currentPassword" placeholder="Password Kamu"/>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="newPassword" id="newPassword" aria-describedby="newPassword" placeholder="Password Kamu"/>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Ulangi Password Baru</label>
                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" aria-describedby="confirmPassword" placeholder="Password Kamu"/>
                    </div>
                    <button class="btn btn-warning">Ganti Password Saya</button>
                </form>

                <h4 class="mt-3">Hapus Akun</h4>
                <p>Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
                <button class="btn btn-danger">Hapus Akun</button>
            </div>
        </div>
        
    </div>    

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#birthdate", {
            dateFormat: "d-m-Y",
            defaultDate: "{{ Auth::user()->birthdate ?? '' }}"
        });
    </script>
</x-app-layout>
