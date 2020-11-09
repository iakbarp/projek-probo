@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Kelola Data Admin | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>KELOLA DATA MASTER USER</h1>
        </div>

        <div class="row">
            <div class="col-8 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Data User</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama User</th>
                                    <th>Email </th>
                                    <th>No. Rekening </th>
                                    <th>Proyek/Layanan </th>
                                    <th>Update Terakhir</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$item->updated_at->diffForHumans()}}</td>

{{--                                        Button search action--}}
{{--                                        <td>--}}
{{--                                            <a href="{{route('admin.show.user.detail',['username'=> $item->username])}}" target="_blank">--}}
{{--                                                <button class="btn btn-primary btn-icon" data-toggle="tooltip" title="Informasi Biodata!"--}}
{{--                                                        onclick="show_bio('{{$item->id}}')"><i--}}
{{--                                                        class="fa fa-search"></i></button>--}}
{{--                                            </a>--}}
{{--                                            <button class="btn btn-info btn-icon" data-toggle="tooltip" title="Proyek User!"--}}
{{--                                                    onclick=""><i--}}
{{--                                                    class="fa fa-briefcase"></i></button>--}}
{{--                                            <button class="btn btn-warning btn-icon" data-toggle="tooltip" title="History User!"--}}
{{--                                                    onclick=""><i--}}
{{--                                                    class="fa fa-briefcase"></i></button>--}}
{{--                                        </td>--}}

                                    </tr>
{{--                                    <tr class="tr-hide" id="bio-{{$item->id}}">--}}
{{--                                        <td colspan="5"  >--}}
{{--                                            <div class="card">--}}
{{--                                                <div class="card-header">--}}
{{--                                                    <h4>Informasi Biodata {{$item->name}}</h4>--}}
{{--                                                </div>--}}
{{--                                                <div class="card-body">--}}
{{--                                                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">--}}
{{--                                                        <li class="media">--}}
{{--                                                            <img alt="image" class="mr-3 rounded-circle" width="70" src="{{asset($item->get_bio->foto)}}">--}}
{{--                                                            <div class="media-body">--}}
{{--                                                                <div class="media-right"><div class="text-primary">Approved</div></div>--}}
{{--                                                                <div class="media-title mb-1">Rizal Fakhri</div>--}}
{{--                                                                <div class="text-time">Yesterday</div>--}}
{{--                                                                <div class="media-description text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse--}}
{{--                                                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non--}}
{{--                                                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>--}}
{{--                                                                <div class="media-links">--}}
{{--                                                                    <a href="#">View</a>--}}
{{--                                                                    <div class="bullet"></div>--}}
{{--                                                                    <a href="#">Edit</a>--}}
{{--                                                                    <div class="bullet"></div>--}}
{{--                                                                    <a href="#" class="text-danger">Trash</a>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </li>--}}
{{--                                                    </ul>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/datatables/datatables.js')}}"></script>
    <script src="{{asset('admins/js/page/modules-datatables.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".tr-hide").hide();
        });

        function show_bio(id) {
            $('#bio-'+id).toggle('slow');
        }
    </script>
@endpush
