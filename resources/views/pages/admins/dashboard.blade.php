@extends('layouts.mst_admin')
@section('title', 'Admin '.env('APP_NAME').': Dashboard | '.env('APP_TITLE'))

@push('styles')
    <style></style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1 class="custom-size-7">DASHBOARD</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="#">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Pernikahan</h4>
                            </div>
                            <div class="card-body">
                                {{count(\App\Model\Pernikahan::all())}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="#">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kelahiran</h4>
                            </div>
                            <div class="card-body">
                                {{count(\App\Model\Kelahiran::all())}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="#">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Meninggal</h4>
                            </div>
                            <div class="card-body">
                                {{count(\App\Model\Kematian::all())}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="#">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Status</h4>
                            </div>
                            <div class="card-body">
                                {{count(\App\Model\StatusPerubahan::all())}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Pernikahan </h4>
                    </div>
                    <div class="card-body" id="top-5-scroll">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach(\App\Model\Pernikahan::orderBy('created_at','DESC')->get()->take(10) as $item)
                                <li class="media">
{{--                                    <img class="mr-3 rounded" width="120" src="{{asset($item->get_user->get_bio->foto !=--}}
{{--'' ? "storage/users/foto/".$item->get_user->get_bio->foto :--}}
{{-- 'admins/img/avatar/avatar-'.rand(1,5).'.png')}}"--}}
{{--                                         alt="avatar user">--}}
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{$item->created_at->diffForHumans()}}</div>
                                        </div>
                                        <div class="media-title">{{$item->get_dokumen->name}}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-label">{!! $item->pt !!}</div>
                                            </div>
                                            <div class="budget-price">
                                                <div class="budget-price-label">Rp. {{number_format($item->get_dokumen->nominal)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Kelahiran </h4>
                    </div>
                    <div class="card-body" id="top-service-scroll">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach(\App\Model\Kelahiran::orderBy('created_at','DESC')->get()->take(10) as $item)
                                <li class="media">
{{--                                    <img class="mr-3 rounded" width="120" src="{{asset($item->get_user->get_bio->foto !=--}}
{{--'' ? "storage/users/foto/".$item->get_user->get_bio->foto :--}}
{{-- 'admins/img/avatar/avatar-'.rand(1,5).'.png')}}"--}}
{{--                                         alt="avatar user">--}}
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{$item->created_at->diffForHumans()}}</div>
                                        </div>
                                        <div class="media-title">{{$item->get_dokumen->name}}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-label">{!! $item->pt !!}</div>
                                            </div>
                                            <div class="budget-price">
                                                <div class="budget-price-label">Rp. {{number_format($item->get_dokumen->nominal)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Meninggal </h4>
                    </div>
                    <div class="card-body" id="top-service-scroll">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach(\App\Model\Kematian::orderBy('created_at','DESC')->get()->take(10) as $item)
                                <li class="media">
                                    {{--                                    <img class="mr-3 rounded" width="120" src="{{asset($item->get_user->get_bio->foto !=--}}
                                    {{--'' ? "storage/users/foto/".$item->get_user->get_bio->foto :--}}
                                    {{-- 'admins/img/avatar/avatar-'.rand(1,5).'.png')}}"--}}
                                    {{--                                         alt="avatar user">--}}
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{$item->created_at->diffForHumans()}}</div>
                                        </div>
                                        <div class="media-title">{{$item->get_dokumen->name}}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-label">{!! $item->pt !!}</div>
                                            </div>
                                            <div class="budget-price">
                                                <div class="budget-price-label">Rp. {{number_format($item->get_dokumen->nominal)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Status </h4>
                    </div>
                    <div class="card-body" id="top-service-scroll">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach(\App\Model\StatusPerubahan::orderBy('created_at','DESC')->get()->take(10) as $item)
                                <li class="media">
                                    {{--                                    <img class="mr-3 rounded" width="120" src="{{asset($item->get_user->get_bio->foto !=--}}
                                    {{--'' ? "storage/users/foto/".$item->get_user->get_bio->foto :--}}
                                    {{-- 'admins/img/avatar/avatar-'.rand(1,5).'.png')}}"--}}
                                    {{--                                         alt="avatar user">--}}
                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{$item->created_at->diffForHumans()}}</div>
                                        </div>
                                        <div class="media-title">{{$item->get_dokumen->name}}</div>
                                        <div class="mt-1">
                                            <div class="budget-price">
                                                <div class="budget-price-label">{{$item->sebelum}}</div>
                                            </div>
                                            <div class="budget-price">
                                                <div class="budget-price-label">{{$item->sesudah}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
