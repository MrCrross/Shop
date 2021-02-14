<?php

namespace App\Models;

use App\Models\Rule;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rules()
    {
        return $this->belongsToMany(Rule::class);
    }

    public function cartsProducts()
    {
        return $this->hasMany(Cart::class)->
                      join('products', 'carts.product_id', '=', 'products.id')->
                      where('archive', '!=', Cart::ARCHIVE)->
                      get();
    }

    /**
     * @param Rule $rule
     * @return bool
     */
    public function hasRule(Rule $rule)
    {
        foreach($this->rules as $ownRule)
        {
            if($ownRule->id == $rule->id)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param array $attributes
     * @return User
     */
    public static function create(array $attributes)
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $createdUser = (new static)->newQuery()->create($attributes);

        return User::find($createdUser['id']);
    }
}
