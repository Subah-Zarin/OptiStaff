@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <!-- Profile Card -->
            <div class="card border-1 shadow-sm rounded-4 overflow-hidden">

                <!-- Top Banner -->
                <div class="bg-secondary" style="height:80px;"></div>

                <!-- Profile Image -->
                <div class="text-center position-relative">
                    <div class="position-absolute top-0 start-50 translate-middle" style="margin-top:40px;">
                        @if($user->profile_photo_path)
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                 class="rounded-circle border border-3 border-white"
                                 width="120" height="120"
                                 style="object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ffffff&color=6c757d&size=200"
                                 class="rounded-circle border border-3 border-white"
                                 width="120" height="120">
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body pt-5 mt-4 px-4">

                    <h4 class="text-center mb-1 fw-bold text-dark">
                        {{ $user->name }}
                    </h4>
                    <p class="text-center text-muted mb-4">
                        Employee Profile
                    </p>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Change Photo -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Profile Picture</label>
                            <input type="file" name="photo" class="form-control form-control-sm">
                            @error('photo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Full Name</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control"
                                   required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control"
                                   required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Birthdate -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Birthdate</label>
                            <input type="date" name="birthdate"
                                   value="{{ old('birthdate', $user->birthdate) }}"
                                   class="form-control">
                            @error('birthdate')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Save Changes
                            </button>
                        </div>

                        @if(session('status') === 'profile-updated')
                            <div class="alert alert-success mt-3 text-center">
                                Profile updated successfully!
                            </div>
                        @endif

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

@endsection
