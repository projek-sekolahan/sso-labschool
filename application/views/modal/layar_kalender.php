        <div class="row">
            <div class="col-12">
            <form class="form-horizontal custom-validation needs-validation" id="form-createScreen" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <label for="Keterangan" class="control-label">Set Aktif</label>
                                <input id="layar-id" name="layar-id" type="hidden" class="form-control" readonly>
                            </div>
                            <div class="col-6 ">
                                <div class="d-inline-block me-1">Tidak</div>
                                <div class="form-check form-switch d-inline-block">
                                    <input type="checkbox" class="form-check-input" id="aktif" name="aktif" style="cursor: pointer;">
                                    <label for="aktif" class="form-check-label">Ya</label>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="card-body">
                        <h4 class="card-title mb-2">Photo Layar Pembuka</h4>
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