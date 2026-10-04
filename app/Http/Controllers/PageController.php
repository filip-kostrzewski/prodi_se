<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

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
            'description' => __('site.meta.privacy_description'),
        ]);
    }
}
