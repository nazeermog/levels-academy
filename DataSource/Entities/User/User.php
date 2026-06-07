<?php

namespace DataSource\Entities\User;


use Laravel\Passport\HasApiTokens;
use DataSource\Entities\User\UserEvent;
use Illuminate\Notifications\Notifiable;
use DataSource\Entities\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Profile photo URL. Returns the stored photo when a profile_photo_path
     * column/file exists, otherwise a generated default avatar (Jetstream-style).
     * This accessor backs the `profile_photo_url` append used in API responses.
     */
    public function getProfilePhotoUrlAttribute()
    {
        $path = $this->attributes['profile_photo_path'] ?? null;
        if ($path) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        $name = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
        if ($name === '') {
            $name = (string) ($this->email ?? 'User');
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

	public function hasRoles($role)
	{
		// Super admin has access to all roles
		if ($this->role === 'super_admin') {
			return true;
		}

		if (is_array($role)) {
			return in_array($this->role, $role, true);
		}

		return $this->role === $role;
	}
    public function events()
    {
        return $this->hasMany(UserEvent::class);
    }

	public function organization()
	{
		return $this->belongsTo(Organization::class, 'organization_id');
	}

	public function scopeInOrganization($query, $organizationId)
	{
		return $query->where('organization_id', $organizationId);
	}
}
