<?php

namespace App\Http\Controllers;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public $inventory = [];
    public $wine = [];
    public function index () {
        set_time_limit(0);
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $browser->request('GET', 'https://www.saq.com/fr/produits/vin');
        $total_items = $crawler->filter('.toolbar-amount')->children()->last()->text();
        $items_per_page = 96;
        $total_pages = (int)($total_items / $items_per_page);

        //set loop for number of pages
        for ($i=0; $i < 10; $i++) { 
            $crawler = $browser->request('GET', 'https://www.saq.com/fr/produits/vin?p='.($i+1).'&product_list_limit='.$items_per_page);
            
            $crawler->filter('li.product-item')->each(function ($node) {
    
                $wine = [];
                //préparer le vin
    
                //traiter les infos(type, size, country)
                $infos = explode('|', $node->filter('.product-item-identity-format')->text());
                $wine['type'] = $infos[0];
                $wine['size'] = $infos[1];
                $wine['country'] = $infos[2];
    
                //traiter le code saq
                $wine['code_saq'] = (float)explode('Code SAQ ', $node->filter('.saq-code')->text())[1];
                
                //traiter le prix
                $wine['price'] = (float)str_replace(',', '.', $node->filter('.price')->text());
    
                // le reste est simplement écrit comme tel
                $wine['photo'] = $node->filter('.product-image-photo')->attr('src');
                $wine['name'] = $node->filter('.product-item-link')->text();
    
                $this->inventory[] = $wine;
            });
        }
        echo '<pre>';
        print_r($this->inventory);
    }
}
