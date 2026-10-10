<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'services' => $this->serviceList(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function services(): View
    {
        return view('pages.services', [
            'services' => $this->serviceList(),
        ]);
    }

    /**
     * Daftar layanan statis untuk tahap awal; dapat dipindah ke database bila perlu.
     *
     * @return list<array{title: string, description: string}>
     */
    private function serviceList(): array
    {
        return [
            ['title' => 'Pembuatan Website', 'description' => 'Website profil perusahaan dan landing page yang cepat, responsif, dan mudah dikelola.'],
            ['title' => 'Aplikasi Web', 'description' => 'Aplikasi internal dengan login, hak akses, dan data terpusat sesuai alur kerja bisnis Anda.'],
            ['title' => 'Pemeliharaan', 'description' => 'Pembaruan konten, pemantauan, dan dukungan teknis berkelanjutan.'],
        ];
    }
}
