<?php

namespace Tests\Feature;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{

    #[Test]
    public function halaman_dashboard_tidak_bisa_diakses_tanpa_login()
    {
        // Pengujian Middleware
        $response = $this->get('/dashboard');

        // Memastikan status redirect 302 ke login
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}