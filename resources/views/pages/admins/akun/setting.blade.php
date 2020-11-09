@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Admin | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{asset($admin->get_bio->foto != '' ? "storage/users/foto/".$admin->get_bio->foto : 'admins/img/avatar/avatar-1.png')}}"
                                 class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">

                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">{{Auth::user()->name}}
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div>
                                    ADMIN
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-12">
                                   <form action="{{route('admin.update.profile')}}" enctype="multipart/form-data" method="post">
                                       @CSRF
                                       <div class="form-group">
                                           <div >Ubah Foto Profil</div>
                                           <div class="input-group mb-3">
                                               <div class="custom-file">
                                                   <input type="file" class="custom-file-input" id="customFile" name="foto">
                                                   <input type="hidden" class="custom-file-input" id="customFile" name="name" value="{{Auth::user()->name}}">
                                                   <label class="custom-file-label" for="customFile">Choose file</label>
                                               </div>
                                               <div class="input-group-append">
                                                   <button class="btn btn-primary" type="submit">Upload</button>
                                               </div>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate=""
                              action="{{route('admin.update.account')}}">
                            @CSRF
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" value="{{Auth::user()->name}}"
                                               required="" name="name">
                                        <div class="invalid-feedback">
                                            Please fill in the first name
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Username</label>
                                        <input type="text" class="form-control" value="{{Auth::user()->username}}"
                                               required="" name="username">
                                        <div class="invalid-feedback">
                                            Please fill in the last name
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control disabled" name="email"
                                               value="{{Auth::user()->email}}" required="" readonly>
                                        <div class="invalid-feedback">
                                            Please fill in the first name
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12">
                                        <label>Password Lama</label>
                                        <input type="password" class="form-control" required="" name="password">
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Password Baru</label>
                                        <input type="password" class="form-control" value="" name="new_password">
                                    </div>
                                    <div class="form-group col-md-4 col-12">
                                        <label>Ketik Ulang Password Baru</label>
                                        <input type="password" class="form-control" value=""
                                               name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
{{--        @if(session('error'))--}}
{{--        swal('Oopss!', '{{ session('expire') }}', 'error');--}}
{{--        @endif--}}
    </script>
@endpush
