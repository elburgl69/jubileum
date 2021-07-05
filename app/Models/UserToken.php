<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Jubileum_token
 *
 * @property integer $id                Unieque ID
 * @property integer $user_id           Id of the user this token belongs to
 * @property integer $event_id          Id of the event this token belongs to
 * @property string $token_name         Name of this token
 * @property string $token              The token it conerns
 * @property boolean $disabled          Is the token disabled
 * @property \Carbon\Carbon $created_at Date the source was creted
 * @property \Carbon\Carbon $updated_at Date the source was last updated
 */
class UserToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'token_name',
        'disabled',
    ];

    /**
     * Find the UserToken by it's Token, Email and Event.
     *
     * An instance is returned if:
     * - A token with $token is found and
     * - Email adress matches the token and
     * - The event of this UserToken matches $event
     *
     * @param string $token
     * @param string $email
     * @param integer $event
     * @return App\Models\UserToken|boolean
     */
    public static function findByToken($token, $email, $event)
    {
        $instance = null;
        $decr = Crypt::decryptString($token);
        if (stristr($decr, $email)) {
            $instance = UserToken::where('token', md5($token))->first();
            if ($instance) {
                if (($instance->event_id != (int) $event)) {
                    $instance = null;
                }
            }
        }
        return $instance;
    }

    /**
     * Hash the token before storing it.
     *
     * @param string $value
     * @return void
     */
    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = md5($value);
    }

    /**
     * Create a token
     *
     * @return string|boolean
     */
    public function makeToken() {
        $user = User::findOrFail($this->user_id);

        if ($user) {
            $tokenBase = Crypt::encryptString($this->token_name . ':' . $user->email);
            return $tokenBase;
        }
        return false;
    }

}
