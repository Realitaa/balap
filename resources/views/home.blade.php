<x-app-layout>
    <x-slot:page>Home</x-slot:page>

    <div class="container">
        <h1>Halo, {{ Auth::user()->name }}!</h1>
        <div class="container">
            <div class="col d-lg-none text-center">
                <img src="{{ asset('img/logo.png') }}" alt="IMI Logo" class="img-fluid" width="200px">
            </div>
            <div class="row">
                <div class="col col-lg-8">
                    <table>
                        <tr>
                            <td><b>Nama</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Lahir</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->birthday }}</td>
                        </tr>
                        <tr>
                            <td><b>Alamat</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->address }}</td>
                        </tr>
                        <tr>
                            <td><b>Kota</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->city }}</td>
                        </tr>
                        <tr>
                            <td><b>Masa Berlaku Hingga</b></td>
                            <td>:</td>
                            <td>{{ Auth::user()->expired_date }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col col-lg-4 d-none d-lg-inline text-center">
                <img src="{{ asset('img/logo.png') }}" alt="IMI Logo" class="img-fluid" width="300px">
                </div>
            </div>
            <a class="btn btn-primary"
            @if (!Auth::user()->birthdate || !Auth::user()->address || !Auth::user()->city)
                data-bs-toggle="modal" data-bs-target="#warningModal"
            @else
                href="{{ route('print') }}"
            @endif
            >Cetak Kartu</a>
        </div>
    </div>    

    @if (!Auth::user()->birthdate || !Auth::user()->address || !Auth::user()->city)
        <x-modal id="warningModal" title="Lengkapi Data Anda" dialog-class="modal-dialog-centered">
            Maaf, Anda harus melengkapi data sebelum mendapatkan kartu Anda.
            
            @slot('actionButton')
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ route('profile') }}" class="btn btn-primary">Lengkapi Data</a>
            @endslot
        </x-modal>
    @endif
    
</x-app-layout>
