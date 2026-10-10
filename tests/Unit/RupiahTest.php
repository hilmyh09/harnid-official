<?php

namespace Tests\Unit;

use App\Support\Rupiah;
use PHPUnit\Framework\TestCase;

class RupiahTest extends TestCase
{
    public function test_formats_integer_amounts_with_thousand_separators(): void
    {
        $this->assertSame('Rp 0', Rupiah::format(0));
        $this->assertSame('Rp 149.000', Rupiah::format(149000));
        $this->assertSame('Rp 1.327.000', Rupiah::format(1327000));
    }
}
