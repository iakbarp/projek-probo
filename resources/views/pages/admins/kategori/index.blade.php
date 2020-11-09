@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Kategori & Sub Kategori | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Kategori dan Sub kategori</h1>
        </div>

        <div class="row">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                   aria-controls="home" aria-selected="true">Kategori</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                   aria-controls="profile" aria-selected="false">Sub Kategori</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                 aria-labelledby="home-tab3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Kategori</h4>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <button class="btn btn-info btn-icon icon-left" id="add_kategori"><i
                                                    class="fa fa-plus"></i> Tambah Data
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th>Task Name</th>

                                                    <th>Terakhir Update</th>

                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($kategori as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>{{$item->nama}}</td>

                                                        <td>{{$item->updated_at->diffForHumans()}}</td>

                                                        <td>
                                                            <form id="delete-form-{{$item->id}}"
                                                                  action="{{ route('admin.show.kategori.delete',['id' => $item->id])}}"
                                                                  method="POST"
                                                                  style="display: none;">

                                                                @csrf
                                                            </form>
                                                            <button class="btn btn-info btn-icon"
                                                                    id="edit-negara-{{$item->id}}"
                                                                    onclick="edit_negara('{{$item->id}}','{{$item->nama}}')">
                                                                <i
                                                                    class="fa fa-edit"></i></button>
                                                            <button class="btn btn-icon"
                                                                    onclick="del({{$item->id}})"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Sub Kategori</h4>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <button class="btn btn-info btn-icon icon-left" id="add_sub"><i
                                                    class="fa fa-plus"></i>
                                                Tambah Data
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-2">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th>Nama Sub Kategori</th>
                                                    <th>Kategori</th>
                                                    <th>Terakhir Update</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sub as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>{{$item->nama}}</td>
                                                        <td>{{$item->get_kategori->nama}}</td>

                                                        <td>{{$item->updated_at->diffForHumans()}}</td>

                                                        <td>
                                                            <form id="delete-form-sub-{{$item->id}}"
                                                                  action="{{ route('admin.show.subkategori.delete',['id' => $item->id])}}"
                                                                  method="POST"
                                                                  style="display: none;">

                                                                @csrf
                                                            </form>
                                                            <button class="btn btn-info btn-icon"><i
                                                                    class="fa fa-edit"
                                                                    onclick="edit_sub('{{$item->id}}','{{$item->nama}}','1')"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-icon"><i
                                                                    class="fa fa-trash"
                                                                    onclick="delsub({{$item->id}})"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <form class="modal-part" id="modal-login-part">
            @CSRF
            <div class="form-group">
                <label>Nama Kategori</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-flag"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="Website.... " name="name" required>
                </div>
            </div>
        </form>

        <form class="modal-part" id="modal-sub-part">
            @CSRF
            <div class="form-group">
                <label>Nama Sub Kategori</label>
                <div class="input-group">

                    <select name="kategori_id" id="kategori_sl" class="form-control selectpicker" data-live-search="true">
                        @foreach($kategori as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>

                <label>Nama Sub Kategori</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-flag"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" placeholder="indonesia " name="name" required>
                </div>
            </div>
        </form>


    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('admins/js/page/modules-datatables.js')}}"></script>
    <script src="{{asset('vendor/select2/dist/js/select2.full.js')}}"></script>
    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });

        function del(id) {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang akan dihapus tidak akan bisa dipulihkan lagi!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#delete-form-' + id).ajaxSubmit({
                            success: function (data) {
                                swal("Poof! Data Berhasil Dihapus!", {
                                    icon: "success",
                                });
                                setTimeout(function () {// wait for 5 secs(2)
                                    location.reload(); // then reload the page.(3)
                                }, 1500);
                            },
                            error: function (xhr) {
                                $('#result-code').text(xhr.status);
                            }
                        });

                    } else {
                        swal("Data Tidak Jadi Dihappus!");
                    }
                });
        }

        function delsub(id) {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang akan dihapus tidak akan bisa dipulihkan lagi!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#delete-form-sub-' + id).ajaxSubmit({
                            success: function (data) {
                                swal("Poof! Data Berhasil Dihapus!", {
                                    icon: "success",
                                });
                                setTimeout(function () {// wait for 5 secs(2)
                                    location.reload(); // then reload the page.(3)
                                }, 1500);
                            },
                            error: function (xhr) {
                                $('#result-code').text(xhr.status);
                            }
                        });

                    } else {
                        swal("Data Tidak Jadi Dihappus!");
                    }
                });
        }

        function update_kategori() {
            $('#modal-edit-kategori').ajaxSubmit({
                success: function (data) {
                    $("#updateKategori").modal('hide');
                    console.log(data);
                    swal("Data Berhasil Diperbarui", {
                        icon: "success",
                    });
                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);
                },
                error: function (xhr, modal) {
                    $('#result-code').text(xhr.status);
                    modal.find('.modal-body').prepend('<div class="alert alert-danger">Data successfully added</div>')
                }
            });
        }

        function edit_negara(id, name) {
            $("#updateKategori").modal('show');
            $("#key_kategori").val(id);
            $("#name_kategori").val(name);

        }

        function edit_sub(id, name, ids) {
            $("#updateSubKategori").modal('show');
            $("#key_subkategori").val(id);
            $("#name_subkategori").val(name);
            $("#kategori_id").val(ids);
        }

        function update_provinsi() {
            $('#modal-edit-prov').ajaxSubmit({
                success: function (data) {
                    $("#updateProvinsiModal").modal('hide');
                    console.log(data);
                    swal("Data Berhasil Diperbarui", {
                        icon: "success",
                    });
                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);
                },
                error: function (xhr, modal) {
                    $('#result-code').text(xhr.status);
                    modal.find('.modal-body').prepend('<div class="alert alert-danger">Data successfully added</div>')
                }
            });
        }

        $("#add_kategori").fireModal({
            title: 'Form Tambah Data Kategori',
            body: $("#modal-login-part"),
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
                        url: "{{route('admin.show.kategori.store')}}",
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

        $("#add_sub").fireModal({
            title: 'Form Tambah Data Sub Kategori',
            body: $("#modal-sub-part"),
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
                        url: "{{route('admin.show.subkategori.store')}}",
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
