<?php
namespace Buttress\Sample;

class Sample
{

    public function twigSample()
    {
        $pkg = \Package::getByHandle('composer_sample');

        $loader = new \Twig_Loader_Filesystem($pkg->getPackagePath() . '/templates/');
        $twig = new \Twig_Environment($loader);

        $response = new \Response();
        $html = $twig->render(
            'sample.twig',
            array(
                'title' => 'Twig Sample',
                'text'  => 'The package was installed successfully so you were redirected here to this twig template ' .
                    'rendered on the fly through a registered route.'));
        $response->setContent($html);

        return $response;
    }

}
