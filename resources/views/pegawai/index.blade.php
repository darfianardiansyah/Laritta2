@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="d-flex justify-content-between align-items-center">
        Data Pegawai
        <button id="btnCreate" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus-fill"></i> Tambah
        </button>
    </h2>

    <div class="table-responsive">
        <table id="pegawaiTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Provinsi</th>
                    <th>Kab/Kota</th>
                    <th>Kecamatan</th>
                    <th>Kode Pos</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('pegawai.modal')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table = $('#pegawaiTable').DataTable({
            ajax: {
                url: "{{ url('pegawai/data') }}",
                type: "GET",
                dataType: "json",
                error: function(xhr, error, thrown) {
                    alert("Gagal mengambil data pegawai. Coba lagi nanti.");
                    console.log("Error:", xhr.responseText);
                }
            },
            columns: [{
                    data: 'nama'
                },
                {
                    data: 'alamat'
                },
                {
                    data: 'provinsi_id'
                },
                {
                    data: 'kabkota_id'
                },
                {
                    data: 'kecamatan_id'
                },
                {
                    data: 'kodepos_id'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<button class="btn btn-warning btnEdit" data-id="${row.id}">Edit</button>
                            <button class="btn btn-danger btnDelete" data-id="${row.id}">Hapus</button>`;
                    }
                }
            ]
        });

        $('#btnCreate').click(function() {
            $('#pegawaiModal').modal('show');
        });

        $(document).on('click', '.btnDelete', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `pegawai/delete/${id}`,
                type: 'DELETE',
                success: function() {
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert("Gagal menghapus data. Silakan coba lagi.");
                    console.log("Error:", xhr.responseText);
                }
            });
        });

        $('#pegawaiForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let url = "{{ url('pegawai/store') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#pegawaiModal').modal('hide');
                    $('#pegawaiForm')[0].reset();
                    table.ajax.reload();
                    alert("Data pegawai berhasil disimpan!");
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Terjadi kesalahan:\n";
                    $.each(errors, function(key, value) {
                        errorMessage += `- ${value}\n`;
                    });
                    alert(errorMessage);
                }
            });
        });

        // Fungsi untuk load dropdown dengan error handling
        function loadDropdown(url, target, placeholder) {
            $(target).empty().append(`<option value="">${placeholder}</option>`).prop('disabled', true);
            $.getJSON(url)
                .done(function(data) {
                    $.each(data.result, function(index, item) {
                        $(target).append(new Option(item.text, item.id));
                    });
                    $(target).prop('disabled', false);
                })
                .fail(function(xhr) {
                    alert(`Gagal memuat data ${placeholder.toLowerCase()}. Coba lagi nanti.`);
                    console.log("Error:", xhr.responseText);
                });
        }

        // Load Provinsi dengan error handling
        loadDropdown("{{ url('api/provinsi') }}", "#provinsi", "Pilih Provinsi");

        $('#provinsi').change(function() {
            let id = $(this).val();
            $('#kabkota').empty().append('<option value="">Pilih Kabupaten/Kota</option>').prop('disabled', true);
            $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
            $('#kodepos').empty().append('<option value="">Pilih Kode Pos</option>').prop('disabled', true);

            if (id) {
                loadDropdown(`{{ url('api/kabkota') }}/${id}`, "#kabkota", "Pilih Kabupaten/Kota");
            }
        });

        $('#kabkota').change(function() {
            let id = $(this).val();
            $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true);
            $('#kodepos').empty().append('<option value="">Pilih Kode Pos</option>').prop('disabled', true);

            if (id) {
                loadDropdown(`{{ url('api/kecamatan') }}/${id}`, "#kecamatan", "Pilih Kecamatan");
            }
        });

        $('#kecamatan').change(function() {
            let kabkota_id = $('#kabkota').val();
            let kecamatan_id = $(this).val();
            $('#kodepos').empty().append('<option value="">Pilih Kode Pos</option>').prop('disabled', true);

            if (kabkota_id && kecamatan_id) {
                loadDropdown(`{{ url('api/kodepos') }}/${kabkota_id}/${kecamatan_id}`, "#kodepos", "Pilih Kode Pos");
            }
        });
    });
</script>
@endpush