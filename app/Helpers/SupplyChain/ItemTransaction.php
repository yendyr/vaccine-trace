<?php

namespace app\Helpers\SupplyChain;

class ItemTransaction
{
    public static function inbound(string $string)
    {
        return strtoupper($string);
    }
}