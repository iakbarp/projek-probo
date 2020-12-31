<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DompetHistory extends Model
{
    protected $table = 'dompet_history';
    protected $guarded = ['id'];

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    public $timestamps = false; //only want to used created_at column

    protected $appends = array('status','isTopup');

    public static function boot()
    {
        parent::boot();


        static::creating(function ($model) {
            $kode = '';
            if ($model->topup_id) {
                $kode = 'TMD';
            } elseif ($model->withdraw_id) {
                $kode = 'WML';
            } elseif ($model->pembayaran_layanan_id) {
                $kode = 'PLN';
            } elseif ($model->pembayaran_id) {
                $kode = 'PPR';
            }

            $kode=$kode . now()->format('ym');
            $id = DompetHistory::query()
                ->select(DB::raw("CONCAT('$kode', RIGHT( ( 100000 + IFNULL( MAX( RIGHT( id, 5 ) ) , 0 ) ) +1, 5 ) ) as nomor"))
                ->where('id','like',"%$kode%")
                ->first();

            $model->id = $id->nomor;
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function getStatusAttribute()
    {
        $status = '';
            if ($this->topup_id) {
                $status = 'Topup';
            } elseif ($this->withdraw_id) {
                $status = 'Withdraw';
            } elseif ($this->pembayaran_layanan_id) {
                $status = 'Pembayaran Layanan';
            } elseif ($this->pembayaran_id) {
                $status = 'Pembayaran Proyek';
            }
        return $status;
    }

    public function getIsTopupAttribute()
    {

        return $this->topup_id?1:0;
    }
}
