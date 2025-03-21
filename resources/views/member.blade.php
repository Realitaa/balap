<x-app-layout>
    <x-slot:page>Member</x-slot:page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="container py-4">
        <div class="text-center mb-4">
            <h2 class="text-3xl font-bold text-gray-800">Tabel Pengguna</h2>
        </div>

        <div class="card border-0 shadow-md rounded-lg">
            <div class="card-body p-4">
                <!-- Tampilkan Pesan -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Masa Berlaku</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->expired_date ?? '' }}</td>
                                <!-- getRoleNameAttribute() in app/Models/User.php -->
                                <td>{{ $member->role_name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-info btn-sm transition-colors hover:bg-info-dark" data-bs-toggle="modal" data-bs-target="#memberModal{{ $member->id }}" title="Informasi Pengguna">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm transition-colors hover:bg-primary-dark ms-3" data-bs-toggle="modal" data-bs-target="#updateMember{{ $member->id }}" title="Perpanjang Masa Berlaku">
                                            <i class="bi bi-clock"></i>
                                        </button>
                                        @if ($member->id != Auth::id())
                                            <button type="button" class="btn btn-danger btn-sm transition-colors hover:bg-danger-dark ms-3" data-bs-toggle="modal" data-bs-target="#deleteMemberModal{{ $member->id }}" title="Hapus Pengguna">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <x-alert type="alert-danger">
                                Tidak ada member.
                            </x-alert>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk setiap member -->
    @foreach ($users as $member)
        <x-modal id="memberModal{{ $member->id }}" title="Detail Member: {{ $member->name }}" dialog-class="modal-lg">
            <div class="text-center mb-4">
                <img src="{{ $member->photo }}" alt="{{ $member->name }}'s photo." class="text-center img-fluid rounded shadow-sm m-3" style="max-width: 200px;">
            </div>
            <table class="table table-bordered table-striped">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>:</td>
                    <td>{{ $member->name }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>:</td>
                    <td>{{ $member->email }}</td>
                </tr>
                <tr>
                    <td><strong>Role</strong></td>
                    <td>:</td>
                    <td>{{ $member->role_name }}</td>
                </tr>
                @if ($member->birthdate)
                    <tr>
                        <td><strong>Tanggal Lahir</strong></td>
                        <td>:</td>
                        <td>{{ $member->birthdate }}</td>
                    </tr>
                @endif
                @if ($member->address)
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>:</td>
                        <td>{{ $member->address }}</td>
                    </tr>
                @endif
                @if ($member->city)
                    <tr>
                        <td><strong>Kota</strong></td>
                        <td>:</td>
                        <td>{{ $member->city }}</td>
                    </tr>
                @endif
                @if ($member->expired_date)
                    <tr>
                        <td><strong>Berlaku</strong></td>
                        <td>:</td>
                        <td>{{ $member->expired_date }}</td>
                    </tr>
                @endif
            </table>
            @slot('actionButton')
                @if (Auth::user()->id != $member->id)
                    @if ($errors->any())
                        <ul class="text-danger mb-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form action="{{ route('update.role'). $member->id }}" method="post">
                        @csrf
                        @method('PUT')
                        @if ($member->role == '2')
                            <input type="hidden" name="role" value="1">
                            <button type="submit" class="btn btn-warning btn-sm transition-colors hover:bg-yellow-600">Jadikan Admin</button>
                        @elseif ($member->role == '1')
                            <input type="hidden" name="role" value="2">
                            <button type="submit" class="btn btn-primary btn-sm transition-colors hover:bg-blue-600">Jadikan Member</button>
                        @endif
                    </form>
                @endif
            @endslot
        </x-modal>

        <x-modal id="deleteMemberModal{{ $member->id }}" title="Hapus Member: {{ $member->name }}?" dialog-class="modal-dialog-centered">
            <p class="text-center text-gray-700">Apakah Anda yakin ingin menghapus member ini?</p>
            @slot('actionButton')
                <form action="{{ route('members.destroy', $member->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm transition-colors hover:bg-red-700">Hapus</button>
                </form>
            @endslot
        </x-modal>

        <x-modal id="updateMember{{ $member->id }}" title="Perpanjang Masa Berlaku" dialog-class="modal-dialog-centered">
            <p class="text-center text-gray-700">Member {{ $member->name }} akan diperpanjang masa berlakunya hingga 1 tahun ke depan.</p>
            @slot('actionButton')
                <form action="{{ route('update.expired_date', $member->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary btn-sm transition-colors hover:bg-blue-600">Perpanjang</button>
                </form>
            @endslot
        </x-modal>
    @endforeach
</x-app-layout>