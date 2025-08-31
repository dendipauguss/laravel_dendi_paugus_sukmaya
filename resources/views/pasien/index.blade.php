@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Data Pasien</h3>
        <div class="mb-3">
            <label>Pilih Rumah Sakit</label>
            <select id="filter-rs" class="form-control">
                <option value="">Semua</option>
                @foreach ($rumahSakit as $rs)
                    <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <button class="btn btn-success" id="btnTambah">Tambah Pasien</button>
        </div>

        <table class="table table-bordered" id="pasien-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pasien</th>
                    <th>Alamat</th>
                    <th>No Telpon</th>
                    <th>Rumah Sakit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasien as $p)
                    <tr id="row-{{ $p->id }}">
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->nama_pasien }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->no_telpon }}</td>
                        <td>{{ $p->rumahSakit->nama_rumah_sakit }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit" data-id="{{ $p->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="{{ $p->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Pasien -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="tambahForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Pasien</label>
                            <input type="text" id="tambah-nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" id="tambah-alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No Telpon</label>
                            <input type="text" id="tambah-telpon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Rumah Sakit</label>
                            <select id="tambah-rs" class="form-control" required>
                                @foreach ($rumahSakit as $rs)
                                    <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pasien -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label>Nama Pasien</label>
                            <input type="text" id="edit-nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" id="edit-alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No Telpon</label>
                            <input type="text" id="edit-telpon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Rumah Sakit</label>
                            <select id="edit-rs" class="form-control" required>
                                @foreach ($rumahSakit as $rs)
                                    <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).on('change', '#filter-rs', function() {
            var rs_id = $(this).val();
            $.get("{{ url('pasien') }}", {
                rumah_sakit_id: rs_id
            }, function(data) {
                var rows = '';
                data.forEach(function(p) {
                    rows += `<tr id="row-${p.id}">
                        <td>${p.id}</td>
                        <td>${p.nama_pasien}</td>
                        <td>${p.alamat}</td>
                        <td>${p.no_telpon}</td>
                        <td>${p.rumah_sakit.nama_rumah_sakit}</td>
                        <td><button class="btn btn-danger btn-sm delete" data-id="${p.id}">Delete</button></td>
                    </tr>`;
                });
                $('#pasien-table tbody').html(rows);
            });
        });

        // Tampilkan modal tambah
        $('#btnTambah').click(function() {
            $('#tambahForm')[0].reset();
            $('#tambahModal').modal('show');
        });

        // Submit form tambah
        $('#tambahForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('pasien') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nama_pasien: $('#tambah-nama').val(),
                    alamat: $('#tambah-alamat').val(),
                    no_telpon: $('#tambah-telpon').val(),
                    rumah_sakit_id: $('#tambah-rs').val()
                },
                success: function(data) {
                    // Tambahkan row baru ke tabel
                    var row = `
            <tr id="row-${data.id}">
                <td>${data.id}</td>
                <td>${data.nama_pasien}</td>
                <td>${data.alamat}</td>
                <td>${data.no_telpon}</td>
                <td>${data.rumah_sakit.nama_rumah_sakit}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit" data-id="${data.id}">Edit</button>
                    <button class="btn btn-danger btn-sm delete" data-id="${data.id}">Delete</button>
                </td>
            </tr>`;
                    $('#pasien-table tbody').append(row);
                    $('#tambahModal').modal('hide');
                    alert('Data berhasil ditambahkan');
                },
                error: function(xhr) {
                    alert('Gagal menambahkan data: ' + xhr.responseText);
                }
            });
        });

        // Tampilkan data di modal saat klik edit
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            $.get("/pasien/" + id + "/edit", function(data) {
                $('#edit-id').val(data.id);
                $('#edit-nama').val(data.nama_pasien);
                $('#edit-alamat').val(data.alamat);
                $('#edit-telpon').val(data.no_telpon);
                $('#edit-rs').val(data.rumah_sakit_id);
                $('#editModal').modal('show');
            });
        });

        // Submit perubahan
        $('#editForm').submit(function(e) {
            e.preventDefault();
            var id = $('#edit-id').val();

            $.ajax({
                url: "/pasien/" + id,
                type: "PUT",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nama_pasien: $('#edit-nama').val(),
                    alamat: $('#edit-alamat').val(),
                    no_telpon: $('#edit-telpon').val(),
                    rumah_sakit_id: $('#edit-rs').val()
                },
                success: function(data) {
                    // Update row di tabel tanpa reload
                    var row = `
            <tr id="row-${data.id}">
                <td>${data.id}</td>
                <td>${data.nama_pasien}</td>
                <td>${data.alamat}</td>
                <td>${data.no_telpon}</td>
                <td>${data.rumah_sakit.nama_rumah_sakit}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit" data-id="${data.id}">Edit</button>
                    <button class="btn btn-danger btn-sm delete" data-id="${data.id}">Delete</button>
                </td>
            </tr>`;
                    $("#row-" + data.id).replaceWith(row);
                    $('#editModal').modal('hide');
                    alert('Data berhasil diperbarui');
                },
                error: function(xhr) {
                    alert('Gagal memperbarui data: ' + xhr.responseText);
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            if (confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: "/pasien/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#row-" + id).remove();
                            alert('Data berhasil dihapus');
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus data: ' + xhr.responseText);
                    }
                });
            }
        });
    </script>
@endsection
