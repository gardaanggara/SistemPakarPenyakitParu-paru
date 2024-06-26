<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Menu Gejala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Button modal insert -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <ion-icon name="add-outline"></ion-icon> Tambahkan Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabulator menampilkan data gejala -->
        <div class="mt-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div id="gejala-list" class="table-responsive"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="addForm" method="POST" action="{{ route('storeGejala') }}"> 
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_gejala" class="form-label">Nama Gejala</label>
                            <input type="text" class="form-control" id="nama_gejala" name="nama_gejala" placeholder="Nama Gejala" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

   <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <form id="editForm" method="POST" action="{{ route('storeGejala', ['id' => 0]) }}">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNama_gejala" class="form-label">Nama Gejala</label>
                            <input type="text" class="form-control" id="editNama_gejala" name="nama_gejala">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!-- Pemanggilan file js pendukung halaman dashboard gejalas -->
    <script src="{{ asset('js/gejalas/index.js') }}"></script>
</x-app-layout>
