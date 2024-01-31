<?php

namespace App\Http\Controllers;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\Request;
use App\Models\Vin;


class ScraperController extends Controller
{


    public function index () {

        $vin = new Vin;
        $vin::truncate();

        // remove php limit time for execution time limit
        set_time_limit(0);

        // instancier l'objet qui aide le crawl
        $browser = new HttpBrowser(HttpClient::create());

        // acceder à la page standard pour déterminer le nombre de pages total
        $crawler = $browser->request('GET', 'https://www.saq.com/fr/produits/vin');
        $total_items = $crawler->filter('.toolbar-amount')->children()->last()->text();

        // le nombre d'items par page est trouvé sur le site saq.com. Les choix sont: 24, 48, 96
        $items_per_page = 96;
        $total_pages = (int)($total_items / $items_per_page) + 1;
        print_r($total_pages);

        // démarrer la boucle pour chaque page. Inscrire $total_pages en condition pour avoir tout les résultats
        /* for ($i=0; $i < $total_pages; $i++) { 

            // acceder à la page
            $crawler = $browser
                ->request('GET', 'https://www.saq.com/fr/produits/vin?p='.($i+1).'&product_list_limit='.$items_per_page);
            
            // filtrer la page pour isoler les items vins et pour chaque items...
            $crawler->filter('li.product-item')->each(function ($node) {
    
                // ...préparer le vin
                $wine = [];
    
                // traiter les infos(type, size, country)
                $infos = explode('|', $node->filter('.product-item-identity-format')->text());
                $wine['type'] = $infos[0];
                $wine['size'] = $infos[1];
                $wine['country'] = $infos[2];
    
                // traiter le code saq
                $wine['code_saq'] = (float)explode('Code SAQ ', $node->filter('.saq-code')->text())[1];
                
                // traiter le prix
                $wine['price'] = (float)str_replace(',', '.', $node->filter('.price')->text());
    
                // le reste est écrit comme tel
                $wine['photo'] = $node->filter('.product-image-photo')->attr('src');
                $wine['name'] = $node->filter('.product-item-link')->text();
    
                // insérer le vin dans l'inventaire, l'étape pour envoyer vers la db peut être fait ici ou sinon envoyer en batch à la fin de la boucle
                $vin = new Vin;
                $vin->create([
                    'name' => $wine['name'],
                    'price' => $wine['price'],
                    'type' => $wine['type'],
                    'size' => $wine['size'],
                    'country' => $wine['country'],
                    'code_saq' => $wine['code_saq'],
                    'photo' => $wine['photo'],
                ]);
            });
        } */
        return $total_pages;
    }
}
