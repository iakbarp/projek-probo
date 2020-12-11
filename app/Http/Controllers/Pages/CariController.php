<?php

namespace App\Http\Controllers\Pages;

use App\Model\Bid;
use App\Model\Project;
use App\Model\ReviewWorker;
use App\Model\Services;
use App\Model\SubKategori;
use App\Model\UlasanService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CariController extends Controller
{
    public function cariData(Request $request)
    {
        $proyek = Project::where('pribadi', false)->doesntHave('get_pengerjaan')->orderByDesc('id')->get();
        $layanan = Services::orderByDesc('id')->get();
        $pekerja = User::whereHas('get_service')->orderByDesc('id')->get();
        $keyword = $request->q;
        $filter = $request->filter;
        $sub_kat = $request->sub_kat;
        $page = $request->hal;

        return view('pages.main.cari-data', compact('proyek', 'layanan', 'pekerja',
            'keyword', 'filter', 'sub_kat', 'page'));
    }

    public function getCariData(Request $request)
    {
        if ($request->filter == 'pekerja') {
            $data = User::whereHas('get_service')->where('name', 'like', '%' . $request->q . '%')
                ->paginate(6)->toArray();

        } else {
            if ($request->filter == 'proyek') {
                $data = Project::where('pribadi', false)->doesntHave('get_pengerjaan')
                    ->where('judul', 'like', '%' . $request->q . '%')
                    ->when($request->sub_kat, function ($q) use ($request) {
                        $q->where('subkategori_id', $request->sub_kat);
                    })->paginate(6)->toArray();
            } else {
                $data = Services::where('judul', 'like', '%' . $request->q . '%')
                    ->when($request->sub_kat, function ($q) use ($request) {
                        $q->where('subkategori_id', $request->sub_kat);
                    })->paginate(6)->toArray();
            }
        }

        return $this->array($data, $request->filter);
    }

    private function array($data, $filter)
    {
        $i = 0;
        foreach ($data['data'] as $row) {
            $user = User::where('id', $filter == 'pekerja' ? $row['id'] : $row['user_id'])->first();
            $bio = $user->get_bio;
            $sub = $filter == 'pekerja' ? null : SubKategori::where('id', $row['subkategori_id'])->first();
            $ulasan_pekerja = ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get();
            $ulasan_layanan = UlasanService::whereHas('get_pengerjaan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();
            $rating_pekerja = count($ulasan_pekerja) + $ulasan_layanan > 0 ?
                $user->get_bio->total_bintang_pekerja / (count($ulasan_pekerja) + $ulasan_layanan) : 0;

            if ($filter == 'proyek') {
                $url = route('detail.proyek', ['username' => $user->username, 'judul' => $row['permalink']]);
                $thumbnail = is_null($row['thumbnail']) ? asset('images/slider/beranda-1.jpg') :
                    asset('storage/proyek/thumbnail/' . $row['thumbnail']);
                $total_bid = Bid::where('proyek_id', $row['id'])->count();
                $deadline = $row['waktu_pengerjaan'];
                $harga = number_format($row['harga'], 2, ',', '.');
                $kategori = $sub->get_kategori->nama;
                $subkategori = $sub->nama;
                $judul = $row['judul'];
                $alamat = 0;
                $bergabung = 0;
                $dilihat =0;
                $deskripsi = Str::words($row['deskripsi'], 20, '...');
            } elseif ($filter == 'layanan') {
                $url = route('detail.layanan', ['username' => $user->username, 'judul' => $row['permalink']]);
                $thumbnail = is_null($row['thumbnail']) ? asset('images/slider/hello.jpg') :
                    asset('storage/layanan/thumbnail/' . $row['thumbnail']);
                $total_bid = 0;
                $harga = number_format($row['harga'], 2, ',', '.');
                $deadline = $row['hari_pengerjaan'];
                $kategori = $sub->get_kategori->nama;
                $subkategori = $sub->nama;
                $judul = $row['judul'];
                $alamat = 0;
                $bergabung =0;
                $dilihat = 0;
                $deskripsi = Str::words($row['deskripsi'], 20, '...');
            } else {
                $url = route('profil.user', ['username' => $user->username]);
                $thumbnail = is_null($bio->foto) ? asset('admins/img/avatar/7.png') :
                    asset('storage/users/foto/' . $bio->foto);
                $total_bid = 0;
                $deadline = 0;
                $harga = 0;
                $kategori = count($user->get_service);
                $judul = $user->name;
                $alamat = is_null($bio->alamat) ? 'Belum menambahkan alamatnya.' : $bio->alamat;
                $bergabung = $user->created_at->formatLocalized('%d %B %Y');
                $dilihat = $user->updated_at->diffForHumans();
                $deskripsi = is_null($bio->summary) ? $user->name . ' belum menuliskan <em>summary</em> atau ringkasan resumenya.' :
                    Str::words($bio->summary, 20, '...');

                if (round($rating_pekerja * 2) / 2 == 1) {
                    $star = '<i class="fa fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 2) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="far fa-star"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 3) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 4) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>' .
                        '<i class="fa fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 5) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>' .
                        '<i class="fr fa-star"></i><i class="fa fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 0.5) {
                    $star = '<i class="fa fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 1.5) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i><i class="far fa-star"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 2.5) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 3.5) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>' .
                        '<i class="fa fa-star-half-alt"></i><i class="far fa-star"></i>';
                } elseif (round($rating_pekerja * 2) / 2 == 4.5) {
                    $star = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>' .
                        '<i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i>';
                } else {
                    $star = '<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>' .
                        '<i class="far fa-star"></i><i class="far fa-star"></i>';
                }

                $subkategori = $star;
            }

            $arr = array(
                'url' => $url,
                '_thumbnail' => $thumbnail,
                'bid' => $total_bid,
                '_harga' => $harga,
                'deadline' => $deadline,
                'kategori' => $kategori,
                'subkategori' => $subkategori,
                'rate' => '<b>' . (round($rating_pekerja * 2) / 2) . '</b> (' . count($ulasan_pekerja) . ' ulasan)',
                'judul' => $judul,
                '_alamat' => $alamat,
                '_deskripsi' => $deskripsi,
                'bergabung' => $bergabung,
                'dilihat' => $dilihat,
            );

            $data['data'][$i] = array_replace($arr, $data['data'][$i]);
            $i = $i + 1;
        }

        return $data;
    }

    public function getCariJudulData(Request $request)
    {
        if ($request->filter == 'pekerja') {
            $data = User::where('name', 'like', '%' . $request->q . '%')->whereHas('get_service')->get();
            foreach ($data as $row) {
                $row->label = $row->name . ' (' . $row->get_service->count() . ' layanan)';
                $row->q = $row->name;
            }

        } else {
            if ($request->filter == 'proyek') {
                $data = Project::where('pribadi', false)->where('judul', 'like', '%' . $request->q . '%')
                    ->doesntHave('get_pengerjaan')->get();
            } else {
                $data = Services::where('judul', 'like', '%' . $request->q . '%')->get();
            }
            foreach ($data as $row) {
                $row->label = $row->get_sub->nama . ' - ' . $row->judul;
                $row->q = $row->judul;
            }
        }

        return $data;
    }
}
