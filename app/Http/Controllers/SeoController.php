<?php

namespace App\Http\Controllers;

use App\Support\Locales;
use Illuminate\Http\Response;
use XMLWriter;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $writer = new XMLWriter;
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $writer->writeAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');

        foreach (array_keys(Locales::PATHS) as $page) {
            foreach (Locales::codes() as $locale) {
                $writer->startElement('url');
                $writer->writeElement('loc', Locales::urlFor($page, $locale));

                foreach (Locales::codes() as $alternate) {
                    $writer->startElement('xhtml:link');
                    $writer->writeAttribute('rel', 'alternate');
                    $writer->writeAttribute('hreflang', Locales::DEFINITIONS[$alternate]['hreflang']);
                    $writer->writeAttribute('href', Locales::urlFor($page, $alternate));
                    $writer->endElement();
                }

                $writer->startElement('xhtml:link');
                $writer->writeAttribute('rel', 'alternate');
                $writer->writeAttribute('hreflang', 'x-default');
                $writer->writeAttribute('href', Locales::urlFor($page, Locales::DEFAULT));
                $writer->endElement();

                $writer->endElement();
            }
        }

        $writer->endElement();
        $writer->endDocument();

        return response($writer->outputMemory(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function robots(): Response
    {
        $body = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Sitemap: '.url('/sitemap.xml'),
            '',
        ]);

        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
