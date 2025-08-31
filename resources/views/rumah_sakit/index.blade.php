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
                            <button class="btn btn-danger btn-sm delete" data-id="{{ $p->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
