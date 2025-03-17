<div id="pegawaiModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Pegawai</h4>
            </div>
            <div class="modal-body">
                <form id="pegawaiForm">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama :</label>
                        <input type="text" id="nama" name="nama" placeholder="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat :</label>
                        <textarea name="alamat" placeholder="Alamat" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="provinsi">Provinsi :</label>
                        <select id="provinsi" name="provinsi_id" class="form-control">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kabkota"> Kabupaten/ Kota :</label>
                        <select id="kabkota" name="kabkota_id" class="form-control" disabled>
                            <option value="">Pilih Kabupaten/ Kota</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan/ Kelurahan</label>
                        <select id="kecamatan" name="kecamatan_id" class="form-control" disabled>
                            <option value="">Pilih Kecamatan/ Kelurahan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kodepos">Kecamatan/ Kelurahan</label>
                        <select id="kodepos" name="kodepos_id" class="form-control" disabled>
                            <option value="">Pilih Kode Pos</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
