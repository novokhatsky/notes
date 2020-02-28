<?php

namespace advor\module;

trait CryptoLib
{
    private $CIPHER = 'aes-256-ctr';
    private $HASH = 'sha256';
    private $SHA2LEN = 32;
    private $AS_BINARY = true;

    function encrypt($key, $text)
    {
        $ivlen = openssl_cipher_iv_length($this->CIPHER);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt(
                                            $text,
                                            $this->CIPHER,
                                            hash($this->HASH, $key, $this->AS_BINARY),
                                            OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                                            $iv
                                         );
        $hmac = hash_hmac($this->HASH, $iv . $ciphertext_raw, $key, $this->AS_BINARY);

        return base64_encode($iv . $hmac . $ciphertext_raw);
    }

    function decrypt($key, $ciphertext)
    {
        $decode_text = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($this->CIPHER);
        $iv = substr($decode_text, 0, $ivlen);
        $hmac = substr($decode_text, $ivlen, $this->SHA2LEN);
        $ciphertext_raw = substr($decode_text, $ivlen + $this->SHA2LEN);
        $original_plaintext = openssl_decrypt(
                                                $ciphertext_raw,
                                                $this->CIPHER,
                                                hash($this->HASH, $key, $this->AS_BINARY),
                                                OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING,
                                                $iv
                                             );

        $calcmac = hash_hmac($this->HASH, $iv . $ciphertext_raw, $key, $this->AS_BINARY);

        if (!hash_equals($hmac, $calcmac)) {
            return false;
        }

        return $original_plaintext;
    }
}

