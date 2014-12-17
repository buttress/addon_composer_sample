<?php
namespace Buttress\Sample;

use Concrete\Core\Foundation\Service\Provider;

/**
 * Class ServiceProvider
 * This class provides registration for anything and everything that happens on load past autoload.
 *
 * @package Buttress\Sample
 */
class ServiceProvider extends Provider
{

    public function register()
    {
        $this->registerRoutes();
    }

    public function registerRoutes()
    {
        \Route::register(
            '/buttress/sample/twig',
            function () {
                $sample = new \Buttress\Sample\Sample;
                $response = $sample->twigSample();
                $response->send();
            });
    }

}
