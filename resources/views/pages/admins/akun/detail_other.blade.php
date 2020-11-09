@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Detail '.$user->name.' | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail User</h1>
        </div>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{asset($user->get_bio->foto ?? 'admins/img/avatar/avatar-1.png')}}"
                             class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Rating Klien</div>
                                <div class="profile-widget-item-value">{{$user->get_rank_klien()}}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Rating Pekerja</div>
                                <div class="profile-widget-item-value">{{$user->get_rank_pekerja()}}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Project</div>
                                <div class="profile-widget-item-value">{{$user->get_project()->count()}}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Layanan</div>
                                <div class="profile-widget-item-value">{{$user->get_service()->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">{{$user->name}}
                            <div class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> {{$user->email}}</div>
                        </div>
                        {{$user->get_bio->summary}}.
                    </div>
                    <div class="card-footer text-center">
                        {{--                        <div class="font-weight-bold mb-2">Follow Ujang On</div>--}}
                        <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                            <i class="fa fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-social-icon btn-github mr-1">
                            <i class="fa fa-github"></i>
                        </a>
                        <a href="#" class="btn btn-social-icon btn-instagram">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="post" class="needs-validation" novalidate="">
                        <div class="card-header">
                            <h4>Aktivitas User</h4>
                        </div>
                        <div class="card-body">
                            <div class="activities">

                                @foreach($user->get_pengerjaan as $item)
                                    <div class="activity">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-unlock"></i>
                                        </div>
                                        <div class="activity-detail">
                                            <div class="mb-2">
                                                <span class="text-job">{{$item->created_at->diffForHumans()}}</span>
                                                <span class="bullet"></span>

                                                <div class="float-right dropdown">
                                                    <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <div class="dropdown-title">Options</div>
                                                        <a href="#" class="dropdown-item has-icon"><i
                                                                class="fas fa-eye"></i> View</a>
                                                        <a href="#" class="dropdown-item has-icon"><i
                                                                class="fas fa-list"></i> Detail</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a href="#" class="dropdown-item has-icon text-danger"
                                                           data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?"
                                                           data-confirm-text-yes="Yes, IDC"><i
                                                                class="fas fa-trash-alt"></i> Archive</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{$user->name}} mengerjakan {{$item->get_project->judul}}.</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab3" data-toggle="tab" href="#home3" role="tab"
                                   aria-controls="home" aria-selected="true">Proyek<span
                                        class="badge badge-light">{{$user->get_project->count()}}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab"
                                   aria-controls="profile" aria-selected="false">Layanan<span
                                        class="badge badge-light">{{$user->get_service->count()}}</span></a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="home3" role="tabpanel"
                                 aria-labelledby="home-tab3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Proyek yang disediakan oleh user</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th>Nama Proyek</th>

                                                    <th>Terakhir Update</th>

                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($user->get_project as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>{{$item->judul}}</td>

                                                        <td>{{$item->updated_at->diffForHumans()}}</td>

                                                        <td>
                                                            <button class="btn btn-primary btn-icon"
                                                                    data-toggle="tooltip"
                                                                    title="Informasi Lengkap!"
                                                                    onclick="show_info_proyek('{{$item->id}}')"><i
                                                                    class="fa fa-search"></i></button>
                                                        </td>

                                                    </tr>
                                                    <tr class="tr-hide" id="proyek-{{$item->id}}">
                                                        <td colspan="5">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4>Informasi Proyek {{$item->judul}}</h4>
                                                                </div>
                                                                <div class="card-body">
                                                                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                                                        <li class="media">
                                                                            <div class="media-body">
                                                                                <div class="media-right">
                                                                                    <div class="text-primary">
                                                                                        Rp {{number_format($item->harga)}}</div>
                                                                                </div>
                                                                                <div
                                                                                    class="media-title mb-1">{{$user->name}}
                                                                                </div>
                                                                                <div class="text-time"> update
                                                                                    terkahir {{$item->updated_at->diffForHumans()}}</div>
                                                                                <div
                                                                                    class="media-description text-muted">
                                                                                    {!! $item->deskripsi !!}
                                                                                </div>
                                                                                <div class="media-links">
                                                                                    <a href="javascrip::void()">Waktu
                                                                                        Pengerjaan {{$item->waktu_pengerjaan}}
                                                                                        Hari</a>
                                                                                    <div class="bullet"></div>
                                                                                    <a href="#"
                                                                                       class="text-danger"></a>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="media " id="pembelian-{{$item->id}}">
                                                                            <div class="card ">
                                                                                <div class="card-header">
                                                                                    <h4>Riwayat Pengerjaan</h4>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="media-body">
                                                                                        <div class="media-right">
                                                                                            <div class="text-primary">
                                                                                                {{($item->get_pengerjaan->selesai ? "Selesai" :"Belum Selesai")}}</div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="media-title mb-1">{{$item->get_pengerjaan->get_user->name}}
                                                                                        </div>
                                                                                        <div class="text-time">Pengerjaan Mulai
                                                                                            Pada Tanggal
                                                                                            {{\Carbon\Carbon::parse($item->get_pengerjaan->updated_at)->format("d-M-Y")}}</div>
                                                                                        <div
                                                                                            class="media-description text-muted">
                                                                                            {!! $item->get_pengerjaan->get_ulasan_pekerja->deskripsi !!}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="media-links">
                                                                                        <a href="javascrip::void()">
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>  {{ $item->get_pengerjaan->get_ulasan_pekerja->bintang}} / 5
                                                                                        </a>
                                                                                        <div class="bullet"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
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
                                        <h4>Data Layanan yang disediakan oleh user</h4>
                                    </div>
                                    <div class="card-body">
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
                                            @foreach($user->get_service as $item)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>{{$item->judul}}</td>
                                                    <td>{{$item->get_sub->nama}}</td>

                                                    <td>{{$item->updated_at->diffForHumans()}}</td>

                                                    <td>
                                                        <button class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                                title="Informasi Lengkap!"
                                                                onclick="show_info('{{$item->id}}')"><i
                                                                class="fa fa-search"></i></button>
                                                    </td>
                                                </tr>
                                                <tr class="tr-hide" id="info-{{$item->id}}">
                                                    <td colspan="5">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h4>Informasi Layanan {{$item->judul}}</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                                                    <li class="media">
                                                                        <div class="media-body">
                                                                            <div class="media-right">
                                                                                <div class="text-primary">
                                                                                    Rp {{number_format($item->harga)}}</div>
                                                                            </div>
                                                                            <div
                                                                                class="media-title mb-1">{{$user->name}}
                                                                            </div>
                                                                            <div class="text-time"> update
                                                                                terkahir {{$item->updated_at->diffForHumans()}}</div>
                                                                            <div class="media-description text-muted">
                                                                                {!! $item->deskripsi !!}
                                                                            </div>
                                                                            <div class="media-links">
                                                                                <a href="javascrip::void()">Waktu
                                                                                    Pengerjaan {{$item->hari_pengerjaan}}
                                                                                    Hari</a>
                                                                                <div class="bullet"></div>
                                                                                <a href="javascrip::void()" onclick="show_pembelian_layanan('{{$item->id}}')"
                                                                                   class="text-danger">Lihat Riwayat
                                                                                    Pembelian Layanan</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li class="media tr-hide" id="pembelian-{{$item->id}}">
                                                                        <div class="card ">
                                                                            <div class="card-header">
                                                                                <h4>Riwayat Pembelian</h4>
                                                                            </div>
                                                                            @foreach($item->get_pengerjaan_layanan as $buy)
                                                                                <div class="card-body">
                                                                                    <div class="media-body">
                                                                                        <div class="media-right">
                                                                                            <div class="text-primary">
                                                                                               {{($buy->selesai ? "Selesai" :"Belum Selesai")}}</div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="media-title mb-1">{{$buy->get_user->name}}
                                                                                        </div>
                                                                                        <div class="text-time">Pembelian
                                                                                            Pada Tanggal
                                                                                            {{\Carbon\Carbon::parse($item->updated_at)->format("d-M-Y")}}</div>
                                                                                        <div
                                                                                            class="media-description text-muted">
                                                                                            {!! $buy->get_ulasan->deskripsi !!}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="media-links">
                                                                                        <a href="javascrip::void()">
                                                                                            <i class="fa fa-star" aria-hidden="true"></i>  {{ $buy->get_ulasan->bintang}} / 5
                                                                                        </a>
                                                                                        <div class="bullet"></div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </li>
                                                                </ul>

                                                            </div>
                                                        </div>
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
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(".tr-hide").hide();
        });

        function show_info(id) {
            $('#info-' + id).toggle('slow');
        }

        function show_pembelian_layanan(id) {
            $('#pembelian-' + id).toggle('slow');
        }

        function show_info_proyek(id) {
            $('#proyek-' + id).toggle('slow');
        }
    </script>
@endpush
