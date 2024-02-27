        <div class="row">
            <div class="col-12">
            <form class="form-horizontal custom-validation needs-validation" id="form-createUser" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Pribadi</h4>
                            <div class="row">
								<div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="email" class="control-label">Email</label>
                                        <input id="email" name="email" type="email" class="form-control" placeholder="Email" readonly required>
                                        <div class="invalid-feedback">Email Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="phone" class="control-label">Telepon WA</label>
                                        <input id="phone" name="phone" type="number" class="form-control" placeholder="Telepon WA" required>
                                        <div class="invalid-feedback">Telepon Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="control-label">Nomor Induk</label>
                                        <input id="user_id" name="user_id" type="hidden" class="form-control" readonly>
                                        <input id="nomor_induk" name="nomor_induk" type="text" class="form-control" placeholder="Nomor Induk" required>
                                        <div class="invalid-feedback">Nomor Induk Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="Name" class="control-label">Nama Lengkap</label>
                                        <input id="nama_lengkap" name="nama_lengkap" type="text" class="form-control" placeholder="Name" required>
                                        <div class="invalid-feedback">Nama Lengkap Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="Jabatan" class="control-label">Jabatan</label>
                                        <input id="jabatan" name="jabatan" type="text" class="form-control" placeholder="Jabatan" required>
                                        <div class="invalid-feedback">Jabatan Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="Pangkat" class="control-label">Pangkat Golongan</label>
                                        <input id="pangkat_golongan" name="pangkat_golongan" type="text" class="form-control" placeholder="Pangkat Golongan" required>
                                        <div class="invalid-feedback">Pangkat Golongan Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="bagian_divisi" class="control-label">Bidang/Divisi</label>
                                        <input id="bagian_divisi" name="bagian_divisi" type="text" class="form-control" placeholder="Bidang/Divisi" required>
                                        <div class="invalid-feedback">Bidang/Divisi Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Akun Sosial Media</h4>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="link_facebook" class="control-label">Facebook</label>
                                        <input id="link_facebook" name="link_facebook" type="text" class="form-control" placeholder="Link/UrL Akun" required>
                                        <div class="invalid-feedback">Akun Facebook Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="link_instagram" class="control-label">Instagram</label>
                                        <input id="link_instagram" name="link_instagram" type="text" class="form-control" placeholder="Link/UrL Akun" required>
                                        <div class="invalid-feedback">Akun Instagram Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="link_twitter" class="control-label">Twitter</label>
                                        <input id="link_twitter" name="link_twitter" type="text" class="form-control" placeholder="Link/UrL Akun" required>
                                        <div class="invalid-feedback">Akun Twitter Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Foto Pengguna</h4>
                        <div class="card-body dropzone" action="#">
                        
                            <div class="fallback">
                                <input name="img[]" type="file" accept="image/png,image/jpg,image/jpeg" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                </div>
                                <h4>Letakan File atau klik upload.</h4>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary waves-effect waves-light btn-simpan">Simpan</button>
                        </div>
                    </div>
                </div> <!-- end card-->
            </form>
            </div>
        </div>
        <!-- end row -->
