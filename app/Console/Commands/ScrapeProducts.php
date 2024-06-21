<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Goutte\Client;

use App\Models\Product;

class ScrapeProducts extends Command
{
    protected $signature = 'scrape:products';
    protected $description = 'Scrape products from Mercado Livre';

    public function handle()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.mercadolivre.com.br/');

        $crawler->filter('.ui-recommendations-carousel-dual')->each(function ($node) {
            $name = $node->filter('.ui-recommendations-title-link')->text();
            $price = $node->filter('.andes-money-amount__fraction')->text();
            $description = $node->filter('.poly-component__title > p')->text() ?? 'No description';
            $image_url = $node->filter('.poly-component__picture')->attr('src');

            Product::create([
                'name' => $name,
                'price' => floatval(str_replace(['.', ','], ['', '.'], $price)),
                'description' => $description,
                'image_url' => $image_url
            ]);
        });

        $this->info('Products scraped successfully!');
    }
}
