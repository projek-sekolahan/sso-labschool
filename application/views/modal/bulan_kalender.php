<div class="row">
            <div class="col-12">
            <form class="form-horizontal custom-validation needs-validation" id="form-createMonth" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Story Behind</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-2">
                                        <label for="article" class="control-label">Judul Artikel</label>
                                        <input id="article-id" name="article-id" type="hidden" class="form-control" readonly>
                                        <input id="article" name="article" type="text" class="form-control" required>
                                        <div class="invalid-feedback">Artikel Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-2">
                                        <label for="description" class="control-label">Deskripsi Artikel</label>
                                        <textarea  class="form-control tiny" id="description" name="description"></textarea>
                                        <div class="invalid-feedback">Deskripsi Tidak Boleh Kosong.</div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-2">Photo Behind</h4>
                        <div class="card-body dropzone" action="#">
                        
                            <div class="fallback">
                                <input name="vehicle[]" type="file" accept="image/png,image/jpg,image/jpeg" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-2">
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