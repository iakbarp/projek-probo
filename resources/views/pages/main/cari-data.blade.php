@extends('layouts.mst')
@section('title', 'Cari Tugas/Proyek, Layanan, dan Pekerja | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('css/card.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-tabs-responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/grid-list.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.min.css')}}">
    <style>
        blockquote {
            background: unset;
            border-color: unset;
            color: unset;
        }

        .btn-link {
            border: 1px solid #ccc;
        }

        .form-control-2[disabled] {
            cursor: not-allowed;
            background-color: #eee;
            opacity: 1
        }

        .has-feedback .form-control-feedback {
            width: 40px;
            height: 40px;
            line-height: 40px;
        }

        ul.ui-autocomplete {
            color: #122752;
            border-radius: 0 0 1rem 1rem;
        }

        ul.ui-autocomplete .ui-menu-item .ui-state-active,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:focus {
            background: #122752;
            color: #fff;
            border: 1px solid #122752;
        }

        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:focus {
            border-radius: 0 0 1rem 1rem;
        }

        .rate i {
            margin: 0 .5em 0 0 !important;
        }

        .pagination > li > a,
        .pagination > li > span {
            color: #777;
            background-color: #fff;
            border: 1px solid #ddd;
            font-weight: 600;
        }

        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #101c37;
        }

        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            background-color: #122752;
            border-color: #122752;
        }

        .pagination > .disabled > a,
        .pagination > .disabled > a:focus,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > span,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > span:hover {
            pointer-events: none;
        }

        #myTabContent table a {
            color: #777;
            text-decoration: none;
            transition: all .3s ease-in-out;
        }

        #myTabContent table a:hover, #myTabContent table a:focus, #myTabContent table a:active {
            color: #122752;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
@endpush
@section('content')
    <section class="none-margin" style="padding: 40px 0 40px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form id="form-load">
                        <input type="hidden" name="sub_kat" id="sub_kat" value="{{$sub_kat}}">
                        <input type="hidden" name="filter" id="filter" value="{{$filter}}">
                        <div class="form-group has-feedback">
                            <input id="keyword" type="text" name="q" class="form-control" autocomplete="off"
                                   value="{{$keyword}}" placeholder="Cari&hellip;"
                                   style="border-radius: 1rem;margin: 1em auto">
                            <span class="glyphicon glyphicon-remove form-control-feedback"
                                  style="right: 2.5rem;pointer-events: all;cursor: pointer;"></span>
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </form>
                    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                            <li role="presentation" class="active">
                                <a class="nav-item nav-link" href="#proyek" id="proyek-tab" role="tab"
                                   data-toggle="tab" aria-controls="proyek" aria-expanded="true"
                                   onclick="filterData('proyek')">
                                    <i class="fa fa-tasks mr-2"></i>PROYEK <span
                                        class="badge badge-secondary">
                                        {{count($proyek) > 999 ? '999+' : count($proyek)}}</span></a>
                            </li>
                            <li role="presentation" class="next">
                                <a class="nav-item nav-link" href="#layanan" id="layanan-tab" role="tab"
                                   data-toggle="tab" aria-controls="layanan" aria-expanded="true"
                                   onclick="filterData('layanan')">
                                    <i class="fas fa-tools mr-2"></i>LAYANAN <span class="badge badge-secondary">
                                        {{count($layanan) > 999 ? '999+' : count($layanan)}}</span></a>
                            </li>
                            <li role="presentation" class="next">
                                <a class="nav-item nav-link" href="#pekerja" id="pekerja-tab" role="tab"
                                   data-toggle="tab" aria-controls="pekerja" aria-expanded="true"
                                   onclick="filterData('pekerja')">
                                    <i class="fa fa-users mr-2"></i>PEKERJA <span class="badge badge-secondary">
                                        {{count($pekerja) > 999 ? '999+' : count($pekerja)}}</span></a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
                    <div id="myTabContent" class="tab-content">
                        <div class="ajax-loader">
                            <div class="preloader4"></div>
                        </div>
                        <div class="row" id="data"></div>
                        <div class="row text-right">
                            <div class="col-12 myPagination">
                                <ul class="pagination justify-content-end"></ul>
                            </div>
                        </div>
                    </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        var last_page, $keyword = $("#keyword"), $filter = $("#filter"), $sub_kat = $("#sub_kat"),

            $img = $(".breadcrumbs"),
            images = ['beranda-1.jpg', 'beranda-1.jpg'],
            index = 0, maxImages = images.length - 1, timer = setInterval(function () {
                var currentImage = images[index];
                index = (index == maxImages) ? 0 : ++index;
                $img.fadeOut("slow", function () {
                    $img.css("background-image", 'url({{asset('images/slider')}}/' + currentImage + ')');
                    $img.fadeIn("slow");
                });
            }, 5000);

        $(function () {
            $('.ajax-loader').hide();
            $('#data, .myPagination').show();
            $("#" + window.location.hash + "-tab").addClass('show active');
            $("#proyek-tab").parent().next().find('a').click();

            @if($filter != '')
            $("#{{$filter}}-tab").click();
            @else
            $("#proyek-tab").parent().next().click();
            $("#proyek-tab").click();
            @endif
        });

        $keyword.autocomplete({
            source: function (request, response) {
                $.getJSON('/cari/judul/data?filter=' + $filter.val() + '&q=' + $keyword.val(), {
                    name: request.term,
                }, function (data) {
                    response(data);
                });
            },
            focus: function (event, ui) {
                event.preventDefault();
            },
            select: function (event, ui) {
                event.preventDefault();
                $keyword.val(ui.item.q);
                loadData();
            }
        });

        $keyword.on('keyup', function () {
            if (!$keyword.val()) {
                $("#proyek-tab").click();
                loadData();
            }
            $(".glyphicon-remove").show();
        });

        $("#form-load").on('submit', function (e) {
            e.preventDefault();
            loadData();
        });

        function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }

        function filterData(filter) {
            $("#nav-tab a").removeClass('show active');
            $("#myTabContent .tab-pane").addClass('show active');
            $("#" + filter + "-tab").addClass('show active');
            $filter.val(filter);
            loadData();
        }

        $(".sub_kat").on('click', function () {
            $sub_kat.val($(this).data('id'));
            $("#" + $(this).data('filter') + "-tab").click();
            $(".glyphicon-remove").show();
            loadData();
            return false;
        });

        $(".glyphicon-remove").on("click", function () {
            $(this).hide();
            $("#proyek-tab").click();
            $("#sub_kat, #sub_kat, #keyword").val(null);
        });

        function loadData() {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.cari.data')}}",
                    type: "GET",
                    data: $("#form-load").serialize(),
                    beforeSend: function () {
                        $('.ajax-loader').show();
                        $('#data, .myPagination').hide();
                    },
                    complete: function () {
                        $('.ajax-loader').hide();
                        $('#data, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data);
                        $('html,body').animate({scrollTop: $(".none-margin").offset().top}, 500);
                    },
                    error: function () {
                        swal('Oops...', 'Terjadi suatu kesalahan!  Silahkan segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);

            return false;
        }

        $('.myPagination ul').on('click', 'li', function () {
            $('html,body').animate({scrollTop: $("#myTab").offset().top}, 500);

            var $url, page = $(this).children().text(),
                active = $(this).parents("ul").find('.active').eq(0).text(),
                hellip_prev = $(this).closest('.hellip_prev').next().find('a').text(),
                hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/cari/data')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/cari/data')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/cari/data')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/cari/data')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-load").serialize(),
                    beforeSend: function () {
                        $('.ajax-loader').show();
                        $('#data, .myPagination').hide();
                    },
                    complete: function () {
                        $('.ajax-loader').hide();
                        $('#data, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, page);
                    },
                    error: function () {
                        swal('Oops...', 'Terjadi suatu kesalahan!  Silahkan segarkan browser Anda.', 'error');
                    }
                });
            }.bind(this), 800);

            return false;
        });

        function successLoad(data, page) {
            var $result = '', pagination = '', $page = '', sub_kat = '', bid = $filter.val() == 'proyek' ? '' : 'none',
                kat = $filter.val() == 'pekerja' ? 'none' : '', user = $filter.val() == 'pekerja' ? '' : 'none';

            $.each(data.data, function (i, val) {
                $result +=
                    '<div class="list-item">' +
                    '<a href="' + val.url + '">' +
                    '<img style="width: 15%;margin-right: 1em" alt="Thumbnail" src="' + val._thumbnail + '">' +
                    '<div class="list-content">' +

                    '<p class="list-price" style="display: ' + kat + '">' +
                    '<span class="list-category" style="display:' + bid + '">TOTAL BID: <span>' + val.bid + ' bid</span></span>' +
                    '<span class="list-date"><i class="fa fa-calendar-week"></i>'+'Batas Waktu:&nbsp;' + val.deadline + ' hari</span><br>'+
                    '<span style="font-size: 28px;color: black;font-family: Arial">'+'Rp' + val._harga +'</span>' +
                    '<br><sub class="list-category">Kategori ' + val.kategori + ': <span style="color: #0073ff">' + val.subkategori + '</span></sub>' +

                    '<p class="list-price" style="display: ' + user + ';margin-bottom: .5em">' +
                    '<span class="list-date rate">' + val.subkategori + '</span>' + val.rate +
                    '<br><sub class="list-category">' + val.username + '</sub>' +
                    '<br>' +
                    '<br><b class="fa fa-home" style="color: black">&nbsp;'+val._alamat+'</b>' +
                    '<br><b class="fa fa-tools" style="color: black">&nbsp;' + val.kategori + ' layanan</b>' +
                    '<br><b class="fa fa-calendar" style="color: black">&nbsp;Bergabung Sejak&nbsp;'+val.bergabung+'</b>' +
                    '<br><b class="fa fa-clock" style="color: black">&nbsp;Terakhir Dilihat&nbsp;'+val.dilihat+'</b>' +
                    '</p>' +
                    '<br><sub>'+val._deskripsi+'</sub>'+
                    '</div>' +
                    '<b style="font-size: 20px;font-family: Arial;color: #0073ff" class="pull-right">' + val.judul + '</b></p>'+
                    '</a></div>';
            });
            $("#data").empty().append($result);

            if (data.last_page >= 1) {
                if (data.current_page > 4) {
                    pagination += '<li class="page-item first">' +
                        '<a class="page-link" href="' + data.first_page_url + '">' +
                        '<i class="fa fa-angle-double-left"></i></a></li>';
                }

                if ($.trim(data.prev_page_url)) {
                    pagination += '<li class="page-item prev">' +
                        '<a class="page-link" href="' + data.prev_page_url + '" rel="prev">' +
                        '<i class="fa fa-angle-left"></i></a></li>';
                } else {
                    pagination += '<li class="page-item disabled">' +
                        '<span class="page-link"><i class="fa fa-angle-left"></i></span></li>';
                }

                if (data.current_page > 4) {
                    pagination += '<li class="page-item hellip_prev">' +
                        '<a class="page-link" style="cursor: pointer">&hellip;</a></li>'
                }

                for ($i = 1; $i <= data.last_page; $i++) {
                    if ($i >= data.current_page - 3 && $i <= data.current_page + 3) {
                        if (data.current_page == $i) {
                            pagination += '<li class="page-item active"><span class="page-link">' + $i + '</span></li>'
                        } else {
                            pagination += '<li class="page-item">' +
                                '<a class="page-link" style="cursor: pointer">' + $i + '</a></li>'
                        }
                    }
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item hellip_next">' +
                        '<a class="page-link" style="cursor: pointer">&hellip;</a></li>'
                }

                if ($.trim(data.next_page_url)) {
                    pagination += '<li class="page-item next">' +
                        '<a class="page-link" href="' + data.next_page_url + '" rel="next">' +
                        '<i class="fa fa-angle-right"></i></a></li>';
                } else {
                    pagination += '<li class="page-item disabled">' +
                        '<span class="page-link"><i class="fa fa-angle-right"></i></span></li>';
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item last">' +
                        '<a class="page-link" href="' + data.last_page_url + '">' +
                        '<i class="fa fa-angle-double-right"></i></a></li>';
                }
            }
            $('.myPagination ul').html(pagination);

            if ($filter.val() != 'pekerja' && $sub_kat.val()) {
                sub_kat = '&sub_kat=' + $sub_kat.val();
            }
            if (page != "" && page != undefined) {
                $page = '&hal=' + page;
            }
            window.history.replaceState("", "", '{{url('/cari')}}?q=' + $keyword.val() + '&filter=' + $filter.val() +
                sub_kat + $page);
            return false;
        }

        $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
            var $target = $(e.target);
            var $tabs = $target.closest('.nav-tabs-responsive');
            var $current = $target.closest('li');
            var $parent = $current.closest('li.dropdown');
            $current = $parent.length > 0 ? $parent : $current;
            var $next = $current.next();
            var $prev = $current.prev();
            var updateDropdownMenu = function ($el, position) {
                $el
                    .find('.dropdown-menu')
                    .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                    .addClass('pull-xs-' + position);
            };

            $tabs.find('>li').removeClass('next prev');
            $prev.addClass('prev');
            $next.addClass('next');

            updateDropdownMenu($prev, 'left');
            updateDropdownMenu($current, 'center');
            updateDropdownMenu($next, 'right');
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });
    </script>
@endpush
