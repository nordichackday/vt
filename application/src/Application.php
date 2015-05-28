<?php

namespace VT;

use Silex\Provider\FormServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

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
        $this->register(new SerializerServiceProvider());
        $this->register(new TwigServiceProvider());
        $this->register(new FormServiceProvider());
        $this->register(new ValidatorServiceProvider());

        if ($this['debug']) {
            $this->register(new ServiceControllerServiceProvider());
            $this->register(new WebProfilerServiceProvider());
        }

        $this->get('/', function () {
            return 'Hello World!';
        })
            ->bind('fontpage');
    }
}
