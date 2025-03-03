<x-app-layout>
    <x-slot:page>Member</x-slot:page>

    <div class="container">
        <div class="text-center">
            <h2>Tabel Pengguna</h2>
        </div>

            <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
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

                        <table class="table table-bordered text-center">
                            <thead>
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
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#memberModal{{ $member->id }}" title="Informasi Pengguna"><i class="bi bi-info-circle"></i></button>
                                        <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#updateMember{{ $member->id }}" title="Perpanjang Masa Berlaku"><i class="bi bi-clock"></i></button>
                                            @if ($member->id != Auth::id())
                                                <button type="button" class="btn btn-danger ms-3" data-bs-toggle="modal" data-bs-target="#deleteMemberModal{{ $member->id }}" title="Hapus Pengguna"><i class="bi bi-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-alert type="alert-danger">
                                        Tidak ada member.
                                    </x-alert>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>

    </div>

    

<!-- Modal untuk setiap member -->
@foreach ($users as $member)
<x-modal id="memberModal{{ $member->id }}" title="Detail Member: {{ $member->name }}" dialog-class="">
    <img src="{{ $member->photo }}" alt="{{ $member->name }}'s photo." class="text-center img-fluid m-3">
                            <table>
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
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <span class="text-danger">{{ $error }}</span>
                                        @endforeach
                                    </ul>
                            @endif
                                <form action="{{ route('update.role'). $member->id }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    @if ($member->role == '2')
                                        <input type="hidden" name="role" value="1">
                                        <button type="submit" class="btn btn-warning">Jadikan Admin</button>
                                    @elseif ($member->role == '1')
                                        <input type="hidden" name="role" value="2">
                                        <button type="submit" class="btn btn-primary">Jadikan Member</button>
                                    @endif
                                </form>
                        @endif
            @endslot
    </x-modal>

    <x-modal id="deleteMemberModal{{ $member->id }}" title="Hapus Member: {{ $member->name }}?" dialog-class="modal-dialog-centered">
        Apakah Anda yakin ingin menghapus member ini?
        
        @slot('actionButton')
            <form action="{{ route('members.destroy', $member->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        @endslot
    </x-modal>

    <x-modal id="updateMember{{ $member->id }}" title="Perpanjang Masa Berlaku" dialog-class="modal-dialog-centered">
        Member {{ $member->name }} akan diperpanjang masa berlakunya hingga 1 tahun ke depan.
        
        @slot('actionButton')
            <form action="{{ route('update.expired_date', $member->id) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-primary">Perpanjang</button>
            </form>
        @endslot
    </x-modal>  
    @endforeach


</x-app-layout>
