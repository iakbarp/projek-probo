<!doctype html>
<html lang="en">
<style>
    .pos { position: absolute; z-index: 0; left: 0px; top: 0px }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
{{--<div class="pos" id="_0:0" style="top:0">--}}
{{--    <img name="_1170:827" src="{{public_path('images/page_001.jpg')}}" height="1170" width="827" border="0" usemap="#Map"></div>--}}
<p align="center">
    <strong>SURAT PERJANJIAN KERJASAMA {{$data->get_project->judul}}</strong>
    <strong>
<p>
</p>
</strong>
</p>
<p>
<p>
    &#160;
</p>
</p>
<p>
    Yang bertanda tangan dibawah ini:
<p>
</p>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    Nama&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; :    <strong>{{$data->get_project->get_user->name}}</strong>
<p>
</p>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; Jabatan
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; :
    <strong>
        Project Owner
<p>
</p>
</strong>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; Dalam hal ini
    bertindak sebagai <em>Project Owner</em> untuk selanjutnya disebut    <strong>Pihak Pertama</strong>.
<p>
</p>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    Nama&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; :
    <strong>
{{$data->get_user->name}}
<p>
</p>
</strong>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; Jabatan
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; :    <strong>Freelancer</strong>
<p>
</p>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    Dalam hal ini bertindak sebagai <em>Freelancer</em> untuk selanjutnya
    disebut <strong>Pihak Kedua.</strong>
<p>
</p>
</p>
<p>
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; Berdasarkan lelang
    yang diterima, dengan ini <strong>Pihak Kedua</strong> menyatakan sanggup
    dan mampu menjalin kerjasama dengan <strong>Pihak Pertama</strong> dalam
    membangun dan membuat layanan {{$data->get_project->judul}} selama {{$data->get_project->waktu_pengerjaan}} hari
    kerja dengan nominal pembayaran sebesar Rp.{{$data->get_project->harga}} untuk pihak kedua.
<p>
</p>
</p>
<p>
<p>
    &#160;
</p>
</p>
<p align="right">
{{$data->updated_at->formatLocalized('%d %B %Y')}}
<p>
</p>
</p>
<p>
<p>
    &#160;
</p>
</p>
<p>
    Mengetahui,&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    Menyetjui,
<p>
</p>
</p>
<p>
    Disetujui pihak
    kedua&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    Disetujui pihak pertama
<p>
</p>
</p>
<p>
    {{$data->get_user->name}}&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;
    &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;{{$data->get_project->get_user->name}}
<p>
</p>
</p>
</body>
</html>
