<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Src\BoundedContext\User\Application\UserResponse;
use Src\BoundedContext\User\Domain\User as DomainUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function fromDomain(UserResponse $userResponse)
    {
        $user = new self();

        $user->id = $userResponse->id;
        $user->name = $userResponse->name;
        $user->email = $userResponse->email;
        $user->password = $userResponse->password;
        $user->email_verified_at = $userResponse->emailVerifiedDate;
        $user->remember_token = $userResponse->rememberToken;

        return $user;
    }

    public function toDomain()
    {
        return DomainUser::fromPrimitives(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            password: $this->password,
            emailVerifiedDate: $this->email_verified_at,
            rememberToken: $this->remember_token
        );
    }
}
