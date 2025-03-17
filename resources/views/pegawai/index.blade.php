@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Data Pegawai <button id="btnCreate" class="btn btn-primary">Tambah Pegawai</button></h2>

        <table id="pegawaiTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Provinsi</th>
                    <th>Kab/Kota</th>
                    <th>Kecamatan</th>
                    <th>Kode Pos</th>
                    <th>Aksii</th>
                </tr>
            </thead>
        </table>
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
                    }
                });
            });

            $('#pegawaiForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let url = '{{ url('pegawai/store') }}';

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#pegawaiModal').modal('hide');
                        $('#pegawaiForm')[0].reset();
                        $('#pegawaiTable').DataTable().ajax.reload();
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

            // Load Provinsi
            $.getJSON('{{ url('api/provinsi') }}', function(data) {
                $.each(data.result, function(index, item) {
                    $('#provinsi').append(new Option(item.text, item.id));
                });
            });

            // Saat provinsi dipilih
            $('#provinsi').change(function() {
                let id = $(this).val();

                // Reset dan disable kab/kota, kecamatan, kode pos
                $('#kabkota').empty().append('<option value="">Pilih Kabupaten/Kota</option>').prop(
                    'disabled', true);
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled',
                    true);
                $('#kodepos').empty().append('<option value="">Pilih Kode Pos</option>').prop('disabled',
                    true);

                if (id) {
                    $.getJSON(`{{ url('api/kabkota') }}/${id}`, function(data) {
                        $.each(data.result, function(index, item) {
                            $('#kabkota').append(new Option(item.text, item.id));
                        });
                        $('#kabkota').prop('disabled', false);
                    });
                }
            });
            // Saat kab/kota dipilih
            $('#kabkota').change(function() {
                let id = $(this).val();

                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled',
                    true);
                $('#kodepos').empty().append('<option value="">Pilih Kode Pos</option>').prop('disabled',
                    true);

                if (id) {
                    $.getJSON(`{{ url('api/kecamatan') }}/${id}`, function(data) {
                        $.each(data.result, function(index, item) {
                            $('#kecamatan').append(new Option(item.text, item.id));
                        });
                        $('#kecamatan').prop('disabled', false);
                    });
                }
            });

            // Saat kecamatan dipilih
            $('#kecamatan').change(function() {
                let kabkota_id = $('#kabkota').val();
                let kecamatan_id = $(this).val();

                $('#kodepos').empty().append('<option value="">Pilih Kode Pos</option>').prop('disabled',
                    true);

                if (kabkota_id && kecamatan_id) {
                    $.getJSON(`{{ url('api/kodepos') }}/${kabkota_id}/${kecamatan_id}`, function(data) {
                        $.each(data.result, function(index, item) {
                            $('#kodepos').append(new Option(item.text, item.id));
                        });
                        $('#kodepos').prop('disabled', false);
                    });
                }
            });
        });
    </script>
@endpush
