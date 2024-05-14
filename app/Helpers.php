<?php

use App\Models\{User};
use Illuminate\Support\Facades\{Hash, Auth};
use Carbon\Carbon;

if (!function_exists('encryptID')) {
    /**
     * Custom encryption method.
     *
     * @param mixed $value
     * @return string
     */
    function encryptID($value)
    {
        // return $value;
        // Use a secret key for encryption
        $key = config('constants.ENCRYPTION_KEY');
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);

        // Combine the initialization vector and encrypted data
        $result = rtrim(strtr(base64_encode($iv . $encrypted), '+/', '-_'), '=');

        return $result;
    }
}

if (!function_exists('decryptID')) {
    /**
     * Custom decryption method.
     *
     * @param string $value
     * @return mixed
     */
    function decryptID($value)
    {
        // return $value;
        // Use a secret key for decryption
        $key = config('constants.ENCRYPTION_KEY');

        // Decode the base64 string
        $decoded = base64_decode(strtr($value, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($value)) % 4));

        // Extract the initialization vector and encrypted data
        $iv = substr($decoded, 0, 16);
        $encrypted = substr($decoded, 16);

        // Decrypt the data
        $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);

        return $decrypted;
    }
}