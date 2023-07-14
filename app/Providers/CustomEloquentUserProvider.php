<?php

namespace App\Providers;

use App\Ace\Tools\Security;
use Closure;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    protected $exceptFields = [
        'password',
        'is_callback'
    ];
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) ||
            (count($credentials) === 1 && in_array($this->firstCredentialKey($credentials), $this->exceptFields, true))) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (in_array($key, $this->exceptFields, true)) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } elseif ($value instanceof Closure) {
                $value($query);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        $isCallback = $credentials['is_callback'] ?? false;
        if ($isCallback) {
            return $isCallback;
        }
        $plain = $credentials['password'];

        return with(new Security())->validatePassword($plain, $user->getAuthPassword());
    }
}
