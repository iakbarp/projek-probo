<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<p class="MsoNormal" align="center" style="text-align:center;line-height:normal"><b><span lang="EN-ID"
                                                                                          style="font-size:18.0pt; mso-bidi-font-size:11.0pt;font-family:
                                                                                          Gill Sans MT,sans-serif;mso-bidi-font-family:
        Times New Roman;mso-ansi-language:EN-ID">SURAT PERJANJIAN KERJASAMA {{$data->get_project->judul}}
        </span></b><b><span lang="EN-ID"
                            style="font-size:14.0pt; mso-bidi-font-size:11.0pt;font-family:
                            Gill Sans MT,sans-serif;mso-bidi-font-family:
        Times New Roman;mso-ansi-language:EN-ID">
        </span></b></p>

<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span lang="EN-ID" >Yang bertanda tangan dibawah ini:
</p>
    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span > Nama : </span><b><span >{{$data->get_project->get_user->name}}</span></b><span lang="EN-ID">

    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span> Jabatan : <b>Project Owner

    </b></span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span > Dalam hal ini bertindak sebagai <i>Project Owner</i> untuk
    selanjutnya disebut <b>Pihak Pertama</b>.

    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph; line-height:115%"><span > Nama : <b>{{$data->get_user->name}}

    </b></span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span > Jabatan : <b>Freelancer</b>
    <o:p></o:p>
    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph; text-indent:-.5in"><span > Dalam hal ini bertindak sebagai <i>Freelancer</i> untuk selanjutnya disebut <b>Pihak Kedua.</b>

    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span lang="EN-ID"
                                                                                   style="font-size:12.0pt;line-height:107%;font-family:"
                                                                                   Gill Sans MT",sans-serif;
    mso-ansi-language:EN-ID;mso-bidi-font-weight:bold"> Berdasarkan lelang yang diterima, dengan ini <b>Pihak Kedua</b>
    menyatakan sanggup dan mampu menjalin kerjasama dengan <b>Pihak Pertama</b> dalam membangun dan membuat layanan {{$data->get_project->judul}} selama {{$data->get_project->waktu_pengerjaan}} hari kerja dengan nominal pembayaran sebesar Rp.{{$data->get_project->harga}} untuk pihak kedua.
    <o:p></o:p>
    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph"><span lang="EN-ID"
                                                                                   style="font-size:12.0pt;line-height:107%;font-family:"
                                                                                   Gill Sans MT",sans-serif;
    mso-ansi-language:EN-ID;mso-bidi-font-weight:bold">
    <o:p></o:p>
    </span></p>
<p class="MsoNormal" align="right" style="text-align:right"><span lang="EN-ID"
                                                                  style="font-size:12.0pt;line-height:107%;font-family:"
                                                                  Gill Sans MT",sans-serif;
    mso-ansi-language:EN-ID;mso-bidi-font-weight:bold">({{$data->updated_at->formatLocalized('%d %B %Y')}})

    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph; line-height:115%"><span lang="EN-ID"
                                                                                                     style="font-size:12.0pt;line-height:115%; font-family:"
                                                                                                     Gill Sans MT",sans-serif;mso-ansi-language:EN-ID">
    <o:p></o:p>
    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph; text-indent:.5in;line-height:115%"><span
        lang="EN-ID" style="font-size:12.0pt; line-height:115%;font-family:" Gill Sans MT",sans-serif;mso-ansi-language:EN-ID">Mengetahui,
    Menyetjui,
    <o:p></o:p>
    </span></p>
<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph; text-indent:.5in;line-height:115%"><span
        lang="EN-ID" style="font-size:12.0pt; line-height:115%;font-family:" Gill Sans MT",sans-serif;mso-ansi-language:EN-ID">Disetujui
    pihak kedua Disetujui pihak pertama
    <o:p></o:p>
    </span></p>
{{--<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph; text-indent:.5in;line-height:115%"><span--}}
{{--        style="font-size:12.0pt;line-height: 115%;font-family:" Gill Sans--}}
{{--        MT",sans-serif">(created_at)                                 </span><span lang="EN-ID"--}}
{{--                                                                                  style="font-size:12.0pt;line-height:115%;font-family:"--}}
{{--                                                                                  Gill Sans MT",sans-serif;--}}
{{--    mso-ansi-language:EN-ID;mso-bidi-font-weight:bold"> (updated_at)--}}
{{--    <o:p></o:p>--}}
{{--    </span></p>--}}
</body>
</html>
