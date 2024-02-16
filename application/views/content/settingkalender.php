<div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Kalender Kegiatan</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pengaturan</a></li>
                                    <li class="breadcrumb-item active">Kalender Kegiatan</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row temp-calendar">
                    <div class="col-12">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="external-events" class="grid-event mt-2">
                                            <br>
                                            <div class="text-center">
                                                <p class="text-muted lead">Geser dan Letakan atau Klik Kalendar untuk Menambah atau Merubah Kegiatan</p>
                                            </div>
                                            <div class="external-event fc-event bg-success" data-class="bg-success">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Hari Penting
                                            </div>
                                            <div class="external-event fc-event bg-primary" data-class="bg-primary">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Hari Kegiatan
                                            </div>
                                            <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Hari Libur
                                            </div>
                                        </div>
                                        <div class="row justify-content-center mt-5">
                                            <img src="assets/images/verification-img.png" alt="" class="img-fluid d-block">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="calendar" class="calendar"></div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <div style='clear:both'></div>

                        <!-- Add New Event MODAL -->
                        <div class="modal fade" id="event-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header py-3 px-4 border-bottom-0">
                                        <h5 class="modal-title" id="modal-title">Event</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form class="form-horizontal custom-validation needs-validation" name="form-event" id="form-event" novalidate method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Keterangan</label>
                                                        <input class="form-control" type="hidden" name="event-id" id="event-id" readonly />
                                                        <input class="form-control" type="hidden" name="event-date" id="event-date" readonly />
                                                        <input class="form-control" placeholder="Keterangan Pada Tanggal" type="text" name="event-title" id="event-title" required />
                                                        <div class="invalid-feedback">Please provide a valid event name</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kategori</label>
                                                        <select class="form-control form-select" name="event-category" id="event-category" required>
                                                            <option value=""> --Pilih Kategori-- </option>
                                                            <option value="bg-primary/kegiatan">Hari Kegiatan</option>
                                                            <option value="bg-danger/libur">Hari Libur</option>
                                                            <option value="bg-success/penting">Hari Penting</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a valid event category</div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <div class="row d-flex justify-content-between">
                                                            <div class="col-6">
                                                                <label for="Keterangan" class="control-label">Tambah Artikel</label>
                                                            </div>
                                                            <div class="col-6 ">
                                                                <div class="d-inline-block me-1">Tidak</div>
                                                                <div class="form-check form-switch d-inline-block">
                                                                    <input type="checkbox" class="form-check-input" id="artikel" name="artikel" style="cursor: pointer;">
                                                                    <label for="artikel" class="form-check-label">Ya</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="article-section d-none">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Judul Artikel</label>
                                                            <input class="form-control" placeholder="Judul Artikel" type="text" name="article-title" id="article-title" />
                                                            <div class="invalid-feedback">Please provide a valid article name</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Isi Artikel</label>
                                                            <textarea  class="form-control tiny" placeholder="Isi Artikel" id="article-description"></textarea>
                                                            <div class="invalid-feedback">Please provide a valid article description</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="article-pic" class="form-label">Upload Gambar Artikel</label>
                                                            <div class="input-group mb-2 dropzone" action="#">
                                                                <div class="fallback">
                                                                    <input name="pic[]" type="file" accept="image/png,image/jpg,image/jpeg" multiple />
                                                                </div>
                                                                <div class="dz-message needsclick">
                                                                    <div class="mb-2">
                                                                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                                    </div>
                                                                    <h4>Letakan File atau klik upload.</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger" id="btn-delete-event" data-view="delete" data-ket="calendar">Delete</button>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> <!-- end modal-content-->
                            </div> <!-- end modal dialog-->
                        </div>
                        <!-- end modal-->

                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->