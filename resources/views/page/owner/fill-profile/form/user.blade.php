<div class="tab-pane" id="progress-seller-details">
    <div class="mb-4">
        <h5>User Details</h5>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="mb-3">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                    name="firstName" value="{{ old('firstName', $userProfile->first_name) }}" autofocus required>
                @error('firstName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="mb-3">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                    name="lastName" value="{{ old('lastName', $userProfile->last_name) }}" required>
                @error('lastName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="mb-3">
                <label for="nickName" class="form-label">Nickname</label>
                <input type="text" class="form-control @error('nickName') is-invalid @enderror" id="nickName"
                    name="nickName" value="{{ old('nickName', $userProfile->nickname) }}" required>
                @error('nickName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="mb-3">
                <label for="gender"class="form-label">Gender</label>
                <select name="gender" id="gender" class="select form-small">
                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>{{ Str::ucfirst('male') }}
                    </option>
                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>
                        {{ Str::ucfirst('female') }}</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    name="phone" value="{{ old('phone', $userProfile->phone) }}" required>
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="mb-3">
                <label for="birthDate" class="form-label">Birth Date</label>
                <input type="date" class="form-control @error('birthDate') is-invalid @enderror" id="birthDate"
                    name="birthDate" value="{{ old('birthDate', $userProfile->birthDate, date('Y-m-d')) }}">
                @error('birthDate')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="mb-3">
                <label for="address" class="form-label">Your Address <span class="text-muted">(optional)</span></label>
                <textarea name="address" class="form-control" id="address" rows="3" cols="10">{{ old('address', $userProfile->address) }}</textarea>
            </div>
        </div>
    </div>
    <ul class="pager wizard twitter-bs-wizard-pager-link justify-content-end">
        <li class="next"><a href="javascript: void(0);" class="btn btn-primary" onclick="nextTab()">Next<i
                    class="bx bx-chevron-right ms-1"></i></a>
        </li>
    </ul>
</div>
