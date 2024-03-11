<div class="row">
    <div class="col-12">
        <form
            class="form-horizontal custom-validation needs-validation"
            action="/api/client/pages/create_update"
            id="form-createPages"
            novalidate="novalidate"
            method="post"
            accept-charset="utf-8"
            enctype="multipart/form-data">
			<div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Menu Akses</h4>
					<div class="row">
						<div class="col-4">
							<div class="mb-3">
								<label for="nama_menu" class="control-label">Name Pages</label>
								<input id="nama_menu" name="nama_menu" type="text" class="form-control" placeholder="Nama Menu" required>
								<div class="invalid-feedback">Name Pages Tidak Boleh Kosong.</div>
							</div>
						</div>
						<div class="col-4">
							<div class="mb-3">
								<label for="title" class="control-label">Sub Pages</label>
								<input id="title" name="title" type="text" class="form-control" placeholder="Sub Menu" required>
								<div class="invalid-feedback">Sub Pages Tidak Boleh Kosong.</div>
							</div>
						</div>
						<div class="col-4">
							<div class="mb-3">
								<label for="url" class="control-label">Url Input</label>
								<input id="url" name="url" type="text" class="form-control" placeholder="URL Input" required>
								<div class="invalid-feedback">URL Input Tidak Boleh Kosong.</div>
							</div>
						</div>
						<div class="col-12">
							<div class="mb-3">
								<label for="tipe_site" class="control-label">Site Type</label>
								<input
								name="id"
								id="id"
								type="hidden"
								class="form-control"
								readonly="readonly">
								<select
									name="tipe_site"
									id="tipe_site"
									class="form-control"
									required="required">
									<option value="">Pilih Site Type</option>
									<option value="1">Dashboard</option>
								</select>
								<div class="invalid-feedback">Pilih Site Type.</div>
							</div>
						</div>
						<div class="col-6">
							<div class="form-check form-switch form-switch-lg mb-3">
								<input
									class="form-check-input"
									type="checkbox"
									id="isChild"
									name="isChild">
									<label class="form-check-label" for="isChild">isChildMenu</label>
							</div>
						</div>
						<div class="col-6">
							<select
								name="is_parent"
								id="is_parent"
								class="form-control"
								required="required">
								<option value="">Pilih Pages Parent</option>
								<option value="1">Dashboard</option>
							</select>
						</div>
						<div class="col-6">
							<div class="form-check form-switch form-switch-lg mb-3">
								<input
									class="form-check-input"
									type="checkbox"
									id="is_execute"
									name="is_execute">
									<label class="form-check-label" for="is_execute">isActive</label>
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label for="icon" class="control-label">Icon Pages</label>
								<input id="icon" name="icon" type="text" class="form-control" placeholder="icon Input" required>
								<div class="invalid-feedback">icon Input Tidak Boleh Kosong.</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </form>
    </div>
</div>
