<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EncryptedArray implements CastsAttributes
{
    /**
     * Cast the given value (Decrypt and Decode)
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return [];
        }

        try {
            // Attempt to decrypt
            $decrypted = Crypt::decryptString($value);
            return json_decode($decrypted, true) ?: [];
        } catch (DecryptException $e) {
            // If decryption fails, it might be raw JSON (old data)
            return json_decode($value, true) ?: [];
        }
    }

    /**
     * Prepare the given value for storage (Encode and Encrypt)
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        // Always Encode then Encrypt on save
        $json = json_encode($value);
        return Crypt::encryptString($json);
    }
}
