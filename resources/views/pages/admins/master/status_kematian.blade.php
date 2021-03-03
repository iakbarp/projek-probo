@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Negara | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Kelola Data Master Status</h1>
        </div>

        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                   aria-controls="home" aria-selected="true">Kematian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                   aria-controls="profile" aria-selected="false">Pernikahan</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                 aria-labelledby="home-tab3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Status Kematian</h4>
                                    </div>
                                    <div class="card-body">
{{--                                        <div>--}}
{{--                                            <button class="btn btn-info btn-icon icon-left" id="add_country"><i--}}
{{--                                                    class="fa fa-plus"></i> Tambah Data--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
                                        <div class="table-responsive">
                                            <table class="table table-striped dtable" id="">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th>Tanggal Input</th>
                                                    <th>Jenis Perubahan</th>
                                                    <th>Nama</th>
                                                    <th>NIK</th>
                                                    <th>Dept.</th>
                                                    <th>Posisi Grup</th>
                                                    <th>Nama Meninggal</th>
                                                    <th>Status Meninggal</th>
                                                    <th>Uang Duka</th>
                                                    <th>Surat/Akte Kematian</th>
                                                    {{--                                    <th>Akte Kematian</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
{{--                                                        <td>--}}
{{--                                                            <a id="lihat-kematian-{{$item->id}}"--}}
{{--                                                               onclick="lihat_kematian('{{$item->nik}}','{{$item->name}}','{{$item->dept}}'--}}
{{--                                                                   ,'{{$item->group}}','{{$item->meninggal}}','{{$item->status_meninggal}}','{{$item->uang_duka}}')">--}}
{{--                                                                <u style="color: blue" >{{$item->name}}</u></a>--}}
{{--                                                        </td>--}}
                                                        <td>
                                                            {{$item->created_at->formatLocalized('%A, %d %B %Y')}}
                                                        </td>
                                                        <td>{{$item->jenis_perubahan}}</td>
                                                        @if($item->old_name == $item->new_name)
                                                            <td>
                                                                {{$item->new_name}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>{{$item->old_name}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>{{$item->new_name}}</b></span>
                                                            </td>
                                                        @endif
{{--                                                        <td>{{$item->name}}</td>--}}
                                                        @if($item->old_nik == $item->new_nik)
                                                        <td>
                                                            {{$item->new_nik}}
                                                        </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>{{$item->old_nik}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>{{$item->new_nik}}</b></span>
                                                            </td>
                                                        @endif
                                                        @if($item->old_dept == $item->new_dept)
                                                            <td>
                                                                {{$item->new_dept}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>{{$item->old_dept}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>{{$item->new_dept}}</b></span>
                                                            </td>
                                                        @endif
                                                        @if($item->old_group == $item->new_group)
                                                            <td>
                                                                {{$item->new_group}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>{{$item->old_group}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>{{$item->new_group}}</b></span>
                                                            </td>
                                                        @endif
                                                        @if($item->old_meninggal == $item->new_meninggal)
                                                            <td>
                                                                {{$item->new_meninggal}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>{{$item->old_meninggal}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>{{$item->new_meninggal}}</b></span>
                                                            </td>
                                                        @endif
                                                        @if($item->old_status_meninggal == $item->new_status_meninggal)
                                                            <td>
                                                                {{$item->new_status_meninggal}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>{{$item->old_status_meninggal}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>{{$item->new_status_meninggal}}</b></span>
                                                            </td>
                                                        @endif
                                                        @if($item->old_uang_duka == $item->new_uang_duka)
                                                            <td>
                                                                Rp{{number_format($item->new_uang_duka,2,',','.')}}
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>Rp{{number_format($item->old_uang_duka,2,',','.')}}</strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>Rp{{number_format($item->new_uang_duka,2,',','.')}}</b></span>
                                                            </td>
                                                        @endif
                                                        @if($item->old_surat_kematian == $item->new_surat_kematian)
                                                            <td>
                                                                @if(!is_null($item->old_surat_kematian))
                                                                    <a href="{{asset('storage/kematian/surat/'. $item->old_surat_kematian)}}"
                                                                       target="_blank">{{$item->old_surat_kematian}}</a>
                                                                @else
                                                                    <span style="color: red">Surat/Akte Kematian Belum Terisi</span>
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td>
                                                                <span style="color: red"><strike>
                                                                         @if(!is_null($item->old_surat_kematian))
                                                                            <a href="{{asset('storage/kematian/surat/'. $item->old_surat_kematian)}}"
                                                                               target="_blank">{{$item->old_surat_kematian}}</a>
                                                                        @else
                                                                            <span style="color: red">Surat/Akte Kematian Belum Terisi</span>
                                                                        @endif
                                                                    </strike></span>
                                                                <br>
                                                                <span style="color: limegreen"><b>
                                                                         @if(!is_null($item->new_surat_kematian))
                                                                            <a href="{{asset('storage/kematian/surat/'. $item->new_surat_kematian)}}"
                                                                               target="_blank">{{$item->new_surat_kematian}}</a>
                                                                        @else
                                                                            <span style="color: red">Surat/Akte Kematian Belum Terisi</span>
                                                                        @endif
                                                                    </b></span>
                                                            </td>
                                                        @endif
                                                        <td>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="tab-pane fade" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">--}}
{{--                                <div class="card">--}}
{{--                                    <div class="card-header">--}}
{{--                                        <h4>Data Provinsi</h4>--}}
{{--                                    </div>--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div>--}}
{{--                                            <button class="btn btn-info btn-icon icon-left" id="add_province"><i--}}
{{--                                                    class="fa fa-plus"></i>--}}
{{--                                                Tambah Data--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <div class="table-responsive">--}}
{{--                                            <table class="table table-striped dtable">--}}
{{--                                                <thead>--}}
{{--                                                <tr>--}}
{{--                                                    <th class="text-center">--}}
{{--                                                        #--}}
{{--                                                    </th>--}}
{{--                                                    <th>Task Name</th>--}}
{{--                                                    <th>Action</th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                @foreach($provinsi as $item)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            {{ $loop->iteration }}--}}
{{--                                                        </td>--}}
{{--                                                        <td>{{$item->nama}}</td>--}}


{{--                                                        <td>--}}
{{--                                                            <form id="delete-form-provinsi-{{$item->id}}"--}}
{{--                                                                  action="{{ route('admin.show.provinsi.delete',['id' => $item->id])}}"--}}
{{--                                                                  method="POST"--}}
{{--                                                                  style="display: none;">--}}

{{--                                                                @csrf--}}
{{--                                                            </form>--}}
{{--                                                            <button class="btn btn-info btn-icon"><i--}}
{{--                                                                    class="fa fa-edit" onclick="edit_provinsi('{{$item->id}}','{{$item->nama}}')"></i></button>--}}
{{--                                                            <button class="btn btn-icon" style="color: white;background-color: grey"><i--}}
{{--                                                                    class="fa fa-trash"--}}
{{--                                                                    onclick="delprov({{$item->id}})"></i></button>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>


        </div>

{{--        <form class="modal-part" id="modal-login-part">--}}
{{--            @CSRF--}}
{{--            <div class="form-group">--}}
{{--                <label>Nama Negara</label>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <i class="fa fa-flag"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <input type="text" class="form-control" placeholder="indonesia " name="name" required>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--        <form class="modal-part" id="modal-provinsi-part">--}}
{{--            @CSRF--}}
{{--            <div class="form-group">--}}
{{--                <label>Nama Provinsi</label>--}}
{{--                <div class="input-group">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <i class="fa fa-flag"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <input type="text" class="form-control" placeholder="indonesia " name="name" required>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}


    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('admins/js/page/modules-datatables.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('.dtable').DataTable();
        } );
        function del(id) {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang akan dihapus tidak akan bisa dipulihkan lagi!",
                icon: '{{asset('images/red-icon.png')}}',
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

        function delprov(id) {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Data yang akan dihapus tidak akan bisa dipulihkan lagi!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#delete-form-provinsi-' + id).ajaxSubmit({
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

        function update_negara() {
            $('#modal-edit').ajaxSubmit({
                success: function (data) {
                    $("#exampleModal").modal('hide');
                    console.log(data);
                    swal("Data Berhasil Diperbarui", {
                        icon: "success",
                    });
                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);
                },
                error: function (xhr,modal) {
                    $('#result-code').text(xhr.status);
                    modal.find('.modal-body').prepend('<div class="alert alert-danger">Data successfully added</div>')
                }
            });
        }

        function edit_negara(id, name) {
            $("#exampleModal").modal('show');
            $("#key").val(id);
            $("#name").val(name);

        }

        function edit_provinsi(id, name) {
            $("#updateProvinsiModal").modal('show');
            $("#keyprov").val(id);
            $("#nameprov").val(name);

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
                error: function (xhr,modal) {
                    $('#result-code').text(xhr.status);
                    modal.find('.modal-body').prepend('<div class="alert alert-danger">Data successfully added</div>')
                }
            });
        }

        $("#add_country").fireModal({
            title: 'Form Tambah Data Negara',
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
                        url: "{{route('admin.show.negara.store')}}",
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

        $("#add_province").fireModal({
            title: 'Form Tambah Data Provinsi',
            body: $("#modal-provinsi-part"),
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
                        url: "{{route('admin.show.provinsi.store')}}",
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
