<div class="tab-pane" id="progress-company-document">
    <div>
        <div class="mb-4">
            <h5>Detail Bisnismu</h5>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="nameBusiness" class="form-label">Nama Bisnis</label>
                    <input type="text" name="nameBusiness" id="nameBusiness"
                        class="form-control @error('nameBusiness') is-invalid @enderror" autofocus required
                        value="{{ old('nameBusiness') }}">
                    @error('nameBusiness')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="descriptionBusiness" class="form-label">Tentang Bisnismu</label>
                    <input type="text" name="descriptionBusiness" id="descriptionBusiness"
                        class="form-control @error('descriptionBusiness') is-invalid @enderror" autofocus required
                        value="{{ old('descriptionBusiness') }}">
                    @error('descriptionBusiness')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="provinceBusiness" class="form-label">Provinsi</label>
                    <select name="provinceBusiness" id="provinceBusiness" class="select">
                        <option value="null" selected disabled>-- Select --</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}"
                                {{ old('provinceBusiness') === $province->id ? 'selected' : '' }}>{{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="regencyBusiness" class="form-label">Kabupaten</label>
                    <select name="regencyBusiness" id="regencyBusiness" class="select">
                        <option value="0">-- Select --</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="districtBusiness" class="form-label">Kecamatan</label>
                    <select name="districtBusiness" id="districtBusiness" class="select">
                        <option value="0">-- Select --</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <label for="villageBusiness"class="form-label">Desa</label>
                    <select name="villageBusiness" id="villageBusiness" class="select">
                        <option value="0">-- Select --</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="mb-3">
                    <label for="progresspill-pancard-input" class="form-label">Alamat bisnis <span
                            class="text-muted">(tidak wajib)</span></label>
                    <textarea name="addressBusiness" id="addressBusiness" class="form-control text-area-business" rows="3">{{ old('addressBusiness') }}</textarea>
                </div>
            </div>
        </div>
        <ul class="pager wizard twitter-bs-wizard-pager-link justify-content-between">
            <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"
                    onclick="nextTab()">Sebelumnya</a>
            </li>
            <li class="next"><button type="submit" class="btn btn-primary">Simpan Perubahan</button></li>
        </ul>
    </div>
</div>
