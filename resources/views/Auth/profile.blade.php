@extends('components.app')
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <h2 class="page-title mt-2 mb-4">
                Selamat Datang <b>
                    @if(auth()->user()->role == 'admin')
                        {{ auth()->user()->name }}
                    @elseif(auth()->user()->role == 'dosen')
                        {{ auth()->user()->nama_dosen }}
                    @elseif(auth()->user()->role == 'mahasiswa')
                        {{ auth()->user()->nama_mahasiswa }}
                    @endif
                </b>!
            </h2>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="https://pic.onlinewebfonts.com/thumbnails/icons_23733.svg" alt="Foto Profil" class="img-fluid rounded-circle mb-3">
                                <h5>
                                    @if(auth()->user()->role == 'admin')
                                        {{ auth()->user()->name }}
                                    @elseif(auth()->user()->role == 'dosen')
                                        {{ auth()->user()->nama_dosen }}
                                    @elseif(auth()->user()->role == 'mahasiswa')
                                        {{ auth()->user()->nama_mahasiswa }}
                                    @endif
                                </h5>
                            </div>
                            <div class="col-md-9">
                                <h3>Informasi Profil</h3>
                                <table class="table table-bordered">
                                    @if(auth()->user()->role == 'admin')
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td>{{ auth()->user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ auth()->user()->email }}</td>
                                        </tr>
                                    @elseif(auth()->user()->role == 'dosen')
                                        <tr>
                                            <th>NIP</th>
                                            <td>{{ auth()->user()->nip }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td>{{ auth()->user()->nama_dosen }}</td>
                                        </tr>
                                        <tr>
                                            <th>Program Studi</th>
                                            <td>{{ auth()->user()->prodi }}</td>
                                        </tr>
                                    @elseif(auth()->user()->role == 'mahasiswa')
                                        <tr>
                                            <th>NIM</th>
                                            <td>{{ auth()->user()->nim }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td>{{ auth()->user()->nama_mahasiswa }}</td>
                                        </tr>
                                        <tr>
                                            <th>Program Studi</th>
                                            <td>{{ auth()->user()->prodi }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Password</th>
                                        <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">Update Password</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Password Modal -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="update-password-form" method="POST" action="{{ route('profile.update.password') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="current_password">Password Lama</label>
                            <div class="pass-group">
                            <input type="password" class="form-control pass-input" id="current_password" name="current_password" required>
                            <span class="fas fa-eye toggle-password"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <div class="pass-group">
                            <input type="password" class="form-control pass-input" id="new_password" name="new_password" required>
                            <span class="fas fa-eye toggle-password"></span>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <div class="pass-group">
                            <input type="password" class="form-control pass-input" id="new_password_confirmation" name="new_password_confirmation" required>
                            <span class="fas fa-eye toggle-password"></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#update-password-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'PUT',
                url: '{{ route('profile.update.password') }}',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Password berhasil diperbarui', // Sesuaikan teks ini dengan pesan yang Anda inginkan
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = response.redirect;
                            }
                        });
                    } else if (response.error) {
                        Swal.fire({
                            title: 'Error!',
                            text: response.error,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    var jsonResponse = JSON.parse(xhr.responseText);
                    var errorMessage = jsonResponse.error || 'Terjadi kesalahan. Silakan coba lagi.';
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush
