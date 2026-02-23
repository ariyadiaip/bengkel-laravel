<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DiskonTest extends TestCase
{
    #[Test]
    public function perhitungan_diskon_transaksi_harus_akurat()
    {
        $hargaSatuan = 100000;
        $qty = 2;
        $persenDiskon = 10;

        $subtotal = $hargaSatuan * $qty;
        $nominalDiskon = ($subtotal * $persenDiskon) / 100;
        $totalAkhir = $subtotal - $nominalDiskon;

        $this->assertEquals(180000, $totalAkhir);
    }
}