<?php
namespace Concrete\Package\ComposerSample;

use Composer\Package\Loader\InvalidPackageException;
use Concrete\Core\Foundation\Service\ProviderList;
use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\ClassLoader\Psr4ClassLoader;

class Controller extends \Package
{

    protected $pkgHandle = 'composer_sample';
    protected $appVersionRequired = '5.7.0.4';
    protected $pkgVersion = '1.0';

    public function getPackageDescription()
    {
        return t("Sample package that includes composer dependencies");
    }

    public function getPackageName()
    {
        return t("Composer Sample");
    }

    public function install()
    {
        if (!file_exists(__DIR__ . '/vendor')) {
            throw new \Exception('Please install composer dependencies before you install this package. ' .
                                 'Run `cd "' . __DIR__ . '" && composer install`');
        }

        parent::install();

        // Make sure we load everything.
        $this->on_start();

        // This is just to showcase the twig example, this is not needed.
        $redirect = new \RedirectResponse(\URL::to('/buttress/sample/twig'));
        $redirect->send();
        exit;
    }

    public function on_start()
    {
        // Set up our namespaces and composer
        $this->autoload();

        // Register our service provider
        $list = new ProviderList(\Core::getFacadeRoot());
        $list->registerProvider('\\Buttress\\Sample\\ServiceProvider');
    }

    /**
     * Autoload all the things!
     * Here we register our `\Buttress\Sample` namespace, and include composer vendor files
     */
    public function autoload()
    {
        // Custom Namespace classloader for src root
        $loader = new Psr4ClassLoader();
        $loader->addPrefix('\\Buttress\\Sample', __DIR__ . '/src/Buttress/Sample/');
        $loader->register();

        // Initialize composer
        $filesystem = new Filesystem();
        $filesystem->getRequire(__DIR__ . '/vendor/autoload.php');
    }

}
