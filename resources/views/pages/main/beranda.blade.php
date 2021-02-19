@extends('layouts.mst')
@section('title', 'Beranda | '.env('APP_TITLE'))
@push('styles')
    <link rel="stylesheet" href="{{asset('vendor/jquery-ui/jquery-ui.min.css')}}">
    <style>
        .form-control-2[disabled] {
            cursor: not-allowed;
            background-color: #eee;
            opacity: 1
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

        .projects-4 {
            margin: 0 auto;
        }

        .projects-4:after {
            content: '';
            display: block;
            clear: both;
        }

        .projects-4 .item {
            margin-bottom: 20px;
        }

        .rating {
            border: none;
            float: left;
        }

        .rating > input {
            display: none;
        }

        .rating > label:before {
            margin: 0 5px 0 5px;
            font-size: 1.25em;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            display: inline-block;
            content: "\f005";
        }

        .rating > .half:before {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            content: "\f089";
            position: absolute;
        }

        .rating > label {
            color: #ddd;
            float: right;
        }

        .rating > input:checked ~ label,
        .rating:not(:checked) > label:hover,
        .rating:not(:checked) > label:hover ~ label {
            color: #ffc100;
        }

        .rating > input:checked + label:hover,
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label,
        .rating > input:checked ~ label:hover ~ label {
            color: #e1a500;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        var keyword = $("#keyword");

        $(function () {
            $("#testimoni").owlCarousel({
                navigation: false,
                slideSpeed: 600,
                autoPlay: 6000,
                singleItem: true,
                pagination: true,
                navigationText: [
                    "<i class='fa fa-caret-left'></i>",
                    "<i class='fa fa-caret-right'></i>"
                ],
            });
        });

        $("#filter-pencarian > button").on("click", function () {
            $("#btn_reset").show();
            $("#txt_filter").text($(this).text());
            $("#form-pencarian input[name='filter']").val($(this).data('filter'));
            keyword.val(null).removeAttr('disabled').attr('required', 'required')
                .attr('placeholder', 'Cari ' + $(this).text().toLowerCase() + '...').focus();
        });

        keyword.on("keyup", function () {
            $("#btn_reset").show();
        });

        keyword.autocomplete({
            source: function (request, response) {
                $.getJSON('/cari/judul/data?filter=' + $("#form-pencarian input[name='filter']").val() + '&q=' + keyword.val(), {
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
                keyword.val(ui.item.q);
            }
        });

        $("#btn_reset").on("click", function () {
            $(this).hide();
            $("#txt_filter").text('FILTER');
            $("#form-pencarian input[name='filter']").removeAttr('value');
            keyword.removeAttr('required').attr('disabled', 'disabled').attr('placeholder', 'Keyword');
        });

        $("#form-pencarian").on('submit', function (e) {
            e.preventDefault();
            var filter = $("#form-pencarian input[name='filter']").val();

            if (!filter) {
                swal('PERHATIAN!', 'Silahkan pilih filter pencarian terlebih dahulu, terimakasih.', 'warning');
            } else {
                $(this)[0].submit();
            }
        });

        $(window).load(function () {
            var $daftar_terbaru = $("#update-terbaru");

            $daftar_terbaru.isotope({
                itemSelector: '.item',
                filter: '.proyek',
                masonry: {
                    columnWidth: 337,
                    isFitWidth: true,
                }
            });

            $('#filter-daftar a').on('click', function () {
                if ($(this).hasClass('current')) {
                    return false;
                }

                $(this).parents().find('.current').removeClass('current');
                $(this).addClass('current');

                $daftar_terbaru.isotope({
                    filter: $(this).attr('data-filter'),
                });

                if ($(this).attr('data-id') == 'proyek') {
                    $("#btn-more").attr('href', '{{route('cari.data', ['filter' => 'proyek'])}}');
                    $("#btn-more b").html('<i class="fa fa-business-time"></i> TAMPILKAN LEBIH');
                } else if ($(this).attr('data-id') == 'layanan') {
                    $("#btn-more").attr('href', '{{route('cari.data', ['filter' => 'layanan'])}}');
                    $("#btn-more b").html('<i class="fa fa-tools"></i> TAMPILKAN LEBIH');
                } else {
                    $("#btn-more").attr('href', '{{route('cari.data', ['filter' => 'pekerja'])}}');
                    $("#btn-more b").html('<i class="fa fa-hard-hat"></i> TAMPILKAN LEBIH');
                }

                return false;
            });
            $('#filter-pencarian a').on('click', function () {
                if ($(this).hasClass('current')) {
                    return false;
                }

                $(this).parents().find('.current').removeClass('current');
                $(this).addClass('current');

                // $daftar_terbaru.isotope({
                //     filter: $(this).attr('data-filter'),
                });
        });

        @if(session('testimoni'))
        swal('Sukses!', '{{ session('testimoni') }}', 'success');
        @endif
    </script>
@endpush
