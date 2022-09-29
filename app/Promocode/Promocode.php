<?php

namespace App\Promocode;

class Promocode
{

    private $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    private $mask = '****-****';

    public function generateCode(): string
    {
        $characters = $this->characters ?? config('promocodes.allowed_symbols');
        $mask = $this->mask ?? config('promocodes.code_mask');
        $maskLength = substr_count($mask, '*');
        $randomCharacter = [];

        for ($i = 1; $i <= $maskLength; $i++) {
            $character = $characters[rand(0, strlen($characters) - 1)];
            $randomCharacter[] = $character;
        }

        shuffle($randomCharacter);
        $length = count($randomCharacter);

        for ($i = 0; $i < $length; $i++) {
            $mask = preg_replace('/\*/', $randomCharacter[$i], $mask, 1);
        }

        return $mask;
    }

    public function createPromocode(){
        auth()->user()->promocode()->create([
            'reward' => 10,
            'quantity' => 1,
            'promo_code' => $this->generateCode()
        ]);
        return auth()->user();
    }

}
