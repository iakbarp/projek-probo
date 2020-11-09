<?php

namespace App;

use App\Model\Bahasa;
use App\Model\Bio;
use App\Model\Pengerjaan;
use App\Model\PengerjaanLayanan;
use App\Model\Portofolio;
use App\Model\Project;
use App\Model\Review;
use App\Model\ReviewWorker;
use App\Model\Services;
use App\Model\Skill;
use App\Model\Bid;
use App\Model\Testimoni;
use App\Model\UlasanService;
use App\Model\Undangan;
use App\Support\Role;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check whether this user is seeker or not
     * @return bool
     */
    public function isOther()
    {
        return ($this->role == Role::OTHER);
    }

    /**
     * Check whether this user is admin or not
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->role == Role::ADMIN);
    }

    /**
     * Check whether this user is root or not
     * @return bool
     */
    public function isRoot()
    {
        return ($this->role == Role::ROOT);
    }

    public function get_bio()
    {
        return $this->hasOne(Bio::class, 'user_id');
    }

    public function get_bahasa()
    {
        return $this->hasMany(Bahasa::class, 'user_id');
    }

    public function get_skill()
    {
        return $this->hasMany(Skill::class, 'user_id');
    }

    public function get_portofolio()
    {
        return $this->hasOne(Portofolio::class, 'user_id');
    }

    public function get_project()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function get_service()
    {
        return $this->hasMany(Services::class, 'user_id');
    }

    public function get_pengerjaan()
    {
        return $this->hasMany(Pengerjaan::class, 'user_id');
    }

    public function get_rank_klien()
    {
        $collection = collect(Bio::orderByDesc('total_bintang_klien')->get());
        $data = $collection->where('user_id', $this->id);

        return $data->keys()->first() + 1;
    }

    public function get_rank_pekerja()
    {
        $collection = collect(Bio::orderByDesc('total_bintang_pekerja')->get());
        $data = $collection->where('user_id', $this->id);

        return $data->keys()->first() + 1;
    }

    public function get_ulasan()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function get_ulasan_pekerja()
    {
        return $this->hasMany(ReviewWorker::class, 'user_id');
    }

    public function get_testimoni()
    {
        return $this->hasOne(Testimoni::class, 'user_id');
    }

    public function get_bid()
    {
        return $this->hasMany(Bid::class, 'user_id');
    }

    public function get_undangan()
    {
        return $this->hasMany(Undangan::class, 'user_id');
    }

    public function get_pengerjaan_layanan()
    {
        return $this->hasMany(PengerjaanLayanan::class, 'user_id');
    }

    public function get_ulasan_layanan()
    {
        return $this->hasMany(UlasanService::class, 'user_id');
    }

    /**
     * Sends the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPassword($token));
    }
}

class CustomPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        $data = $this->token;
        $email = $notifiable->getEmailForPasswordReset();
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'), env('APP_TITLE'))
            ->subject('Akun ' . env('APP_NAME') . ': Reset Kata Sandi')
            ->view('emails.auth.reset', compact('data', 'email'));
    }
}
