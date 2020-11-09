@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Admin | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Master Admin</h1>
        </div>

        <div class="row">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Admin</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Admin</th>
                                    <th>Nickname Admin</th>
                                    <th>Email Admin</th>
                                    <th>Tanggal Ditambahkan</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admin as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->username}}</td>

                                        <td>{{$item->email}}</td>
                                        <td>{{$item->created_at->diffForHumans()}}</td>

{{--                                        <td>--}}
{{--                                            <form id="delete-form-{{$item->id}}"--}}
{{--                                                  action="{{ route('admin.show.negara.delete',['id' => $item->id])}}"--}}
{{--                                                  method="POST"--}}
{{--                                                  style="display: none;">--}}

{{--                                                @csrf--}}
{{--                                            </form>--}}
{{--                                            <button class="btn btn-info btn-icon"--}}
{{--                                                    id="edit-negara-{{$item->id}}"--}}
{{--                                                    onclick="edit_negara('{{$item->id}}','{{$item->nama}}')">--}}
{{--                                                <i--}}
{{--                                                    class="fa fa-edit"></i></button>--}}
{{--                                            <button class="btn btn-danger btn-icon"--}}
{{--                                                    onclick="del({{$item->id}})"><i--}}
{{--                                                    class="fa fa-trash"></i></button>--}}
{{--                                        </td>--}}

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <button class="btn btn-info btn-icon icon-left" id="add_admin"><i
                                    class="fa fa-plus"></i> Tambah Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <form class="modal-part" id="modal-add-admin">
                @CSRF
                <div class="form-group">
                    <label>Nama</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="Admin.... " name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="adm.... " name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-envelope"></i>
                            </div>
                        </div>
                        <input type="email" class="form-control" placeholder="admin@email.com" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-key"></i>
                            </div>
                        </div>
                        <input type="password" class="form-control" placeholder="******" name="password" required>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('admins/js/page/modules-datatables.js')}}"></script>

    <script !src="">
        $("#add_admin").fireModal({
            title: 'Form Tambah Pengguna Admin',
            body: $("#modal-add-admin"),
            footerClass: 'bg-whitesmoke',
            autoFocus: false,
            onFormSubmit: function (modal, e, form) {
                // Form Data
                let form_data = $(e.target).serialize();
                console.log(form_data);

                // DO AJAX HERE
                let fake_ajax = setTimeout(function () {
                    // form.stopProgress();
                    // modal.find('.modal-body').prepend('<div class="alert alert-info">Please check your browser console</div>')
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.add')}}",
                        data: form_data, // serializes the form's elements.
                        success: function (data) {
                            console.log(data);
                            form.stopProgress();
                            modal.find('.modal-body').prepend('<div class="alert alert-success">Data successfully added</div>')
                            setTimeout(function () {// wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 1500);
                            // alert(data); // show response from the php script.
                        },
                        error: function (data) {
                            console.log(data);
                            form.stopProgress();
                            modal.find('.modal-body').prepend('<div class="alert alert-danger">Something wrong please try again later</div>')
                            // alert(data);
                        }
                    });
                    clearInterval(fake_ajax);
                }, 1500);

                e.preventDefault();
            },
            shown: function (modal, form) {
                console.log(form)
            },
            buttons: [
                {
                    text: 'Submit',
                    submit: true,
                    class: 'btn btn-primary btn-shadow',
                    handler: function (modal) {
                    }
                }
            ]
        });
    </script>
@endpush
