<?php

namespace App\Http\Controllers;

use App\Support\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'title' => __('site.meta.home_title'),
            'description' => __('site.meta.home_description'),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'title' => __('site.meta.contact_title'),
            'description' => __('site.meta.contact_description'),
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy', [
            'title' => __('site.meta.privacy_title'),
            'description' => __('site.meta.privacy_description', ['legal' => Company::legalName()]),
        ]);
    }

    public function dackflowPreview(): Response
    {
        return response()->view('pages.dackflow-preview', [
            'title' => 'Boka tid hos Siemanko — Prodi',
            'description' => 'Förhandsvisning av Däckflow-bokningen, inbäddad på en Prodi-sida.',
        ], 200, [
            'X-Robots-Tag' => 'noindex, nofollow',
        ]);
    }

    public function polfoodPreview(): Response
    {
        return response()->view('pages.polfood-preview', [
            'title' => 'Polfood — projekt wizytówki — Prodi',
            'description' => 'Wizytówka dwustronna, 85 × 55 mm. Przód kremowy z pieczęcią „Anno 1984”, tył burgundowy.',
        ], 200, [
            'X-Robots-Tag' => 'noindex, nofollow',
        ]);
    }
}
