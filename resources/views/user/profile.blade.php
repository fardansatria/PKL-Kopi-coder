<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="{{ asset('Profile Template/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Pengaturan Akun
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Umum</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Ganti Kata Sandi</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Sosial Media</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Koneksi</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notifikasi</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">

                            <!-- Profile Photo -->
                            <div class="form-group">
                                <label for="image">Profile Photo</label>
                                <input type="file" name="image" class="form-control-file">
                                @error('photo')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror

                                @if($profile && $profile->photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/profile_photos/' . $profile->photo) }}" alt="Profile Photo" class="img-thumbnail" width="150">
                                </div>
                                @endif


                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <form method="POST" action="{{ route('user.profile.edit') }}">
                                    @csrf
                                    @method('POST')

                                    <!-- Nama -->
                                    <div class="form-group">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control mb-1" value="{{ old('name', auth()->user()->name) }}" required>
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control mb-1" value="{{ old('email', auth()->user()->email) }}" required>
                                        @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <div class="alert alert-warning mt-3">
                                            Email Anda belum dikonfirmasi. Silakan periksa kotak masuk Anda.<br>
                                            <a href="javascript:void(0)">Kirim ulang konfirmasi</a>
                                        </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="form-group">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="address" class="form-control mb-1" value="{{ old('addres', $profile->addres ?? '') }}">
                                        @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Telepon -->
                                    <div class="form-group">
                                        <label class="form-label">Telepon</label>
                                        <input type="text" name="phone" class="form-control mb-1" value="{{ old('phone', $profile->phone ?? '') }}">
                                        @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <!-- //ganti password -->
                                <form method="POST" action="{{ route('user.profile.password') }}">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <label class="form-label">Kata Sandi Saat Ini</label>
                                        <input type="password" name="current_password" class="form-control">
                                        @error('current_password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Kata Sandi Baru</label>
                                        <input type="password" name="new_password" class="form-control">
                                        @error('new_password')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ulangi Kata Sandi Baru</label>
                                        <input type="password" name="new_password_confirmation" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ganti Kata Sandi</button>
                                </form>
                            </div>
                        </div>

                        <!-- Bagian Tab Lainnya (Info, Sosial Media, Koneksi, dll.) -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>