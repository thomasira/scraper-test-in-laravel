## testing scraping in laravel

## installation and requirement

run-> *composer require symfony/browser-kit*  
run-> *composer require symfony/http-client*  

> ### from clone
> * run-> composer update
> * run-> php artisan serve
> * go to your < host >/test

## config

The scraper is a controller that you can find in *app/http/controllers/ScraperController.php*. 
It returns data from saq.com/produits/vin for 10 pages * 96 results so it might take a while. If you want to change the amount of items returned, change the condition in the *pages* for loop, set to $total_pages for all the result.