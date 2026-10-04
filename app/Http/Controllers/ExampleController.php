<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ExampleController extends Controller
{
    public function cleaning(): View
    {
        return view('examples.cleaning', [
            'title' => __('site.meta.cleaning_title'),
            'description' => __('site.meta.cleaning_description'),
        ]);
    }

    public function painting(): View
    {
        return $this->paintingView('home');
    }

    public function paintingServices(): View
    {
        return $this->paintingView('services');
    }

    public function paintingGallery(): View
    {
        return $this->paintingView('gallery');
    }

    public function paintingContact(): View
    {
        return $this->paintingView('contact');
    }

    private function paintingView(string $section): View
    {
        return view('examples.painting', [
            'title' => __('site.meta.painting_'.$section.'_title'),
            'description' => __('site.meta.painting_description'),
            'section' => $section,
        ]);
    }
}
