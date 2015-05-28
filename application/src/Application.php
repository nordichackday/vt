<?php

namespace VT;

use Silex\Provider\FormServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use VT\Entity\Timeline;

class Application extends \Silex\Application
{
    /**
     * @param string  $rootDir
     * @param string  $environment
     * @param boolean $debug
     */
    public function __construct($rootDir, $environment = 'prod', $debug = false)
    {

        parent::__construct(
            [
                'root_dir'         => $rootDir,
                'cache_dir'        => $rootDir.'/var/cache/'.$environment,
                'config.cache_dir' => $rootDir.'/var/cache/'.$environment.'/config',
                'env'              => $environment,
                'debug'            => $debug,
            ]
        );

        $this->initialize();
    }

    private function initialize()
    {
        $this->register(new UrlGeneratorServiceProvider());
        $this->register(new TwigServiceProvider());
        $this->register(new FormServiceProvider());
        $this->register(new ValidatorServiceProvider());
        $this->register(new SerializerServiceProvider());

        if ($this['debug']) {
            $this->register(new ServiceControllerServiceProvider());
            $this->register(new WebProfilerServiceProvider());
        }

        $this->get('/', function () {
            $timeline = new Timeline('title', 'intro', []);

            return new Response($this['serializer']->serialize($timeline, 'json'), 200, array(
                "Content-Type" => $this['request']->getMimeType('json')
            ));
        })
            ->bind('fontpage');
    }
}
