<?php

namespace VT;

use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VT\Entity\Node;
use VT\Entity\Timeline;

class Application extends \Silex\Application
{
    /**
     * @param string $rootDir
     * @param string $environment
     * @param boolean $debug
     */
    public function __construct($rootDir, $environment = 'prod', $debug = false)
    {

        parent::__construct(
            [
                'root_dir' => $rootDir,
                'cache_dir' => $rootDir . '/var/cache/' . $environment,
                'config.cache_dir' => $rootDir . '/var/cache/' . $environment . '/config',
                'env' => $environment,
                'debug' => $debug,
            ]
        );

        $this->initialize();
    }

    private function initialize()
    {
        $this->register(new UrlGeneratorServiceProvider());
        $this->register(new TwigServiceProvider(), [
            'twig.path' => $this['root_dir'] . '/src/Resources/views'
        ]);
        $this->register(new TranslationServiceProvider(), array(
            'translator.messages' => array(),
        ));
        $this->register(new FormServiceProvider());
        $this->register(new ValidatorServiceProvider());
        $this->register(new SecurityServiceProvider());
        $this->register(new SerializerServiceProvider());
        $this->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_mysql',
                'dbname' => 'nordic',
                'user' => 'virtual2015',
                'password' => 'timeline',
                'host' => 'db4free.net',
            ),
        ));

        if ($this['debug']) {
            $this->register(new ServiceControllerServiceProvider());
            $this->register(new WebProfilerServiceProvider(), [
                'profiler.cache_dir' => $this['cache_dir'] . '/profiler',
                'profiler.mount_prefix' => '/_profiler'
            ]);
        }

        $this['security.firewalls'] = array(
            'admin' => array(
                'pattern' => '^/',
                'anonymous' => true
            ),
        );

        $this->get('/timeline/{id}', function (Application $app, $id) {
            $data = $this['db']->fetchAssoc(
                'SELECT * FROM timeline where id = ?',
                [
                    (int) $id
                ]
            );
            $timeline = new Timeline($data['title'], $data['intro'], []);

            $nodes = $this['db']->fetchAll(
                'SELECT * FROM nodes where tl_id = ? ORDER BY ordering DESC',
                [
                    (int) $id
                ]
            );

            foreach ($nodes as $node) {
                $timeline->addNode(
                    new Node(
                        $node['media_id'],
                        $node['intro'],
                        time(),
                        $node['body']
                    ));
            }

            return new Response($this['serializer']->serialize($timeline,
                'json'), 200, array(
                "Content-Type" => $this['request']->getMimeType('json')
            ));
        });

        $this->get('/timeline/created', function () {
            return $this['twig']->render('created.html.twig');
        });

        $this->match('/timeline/create/', function (Request $request) {
            $form = $this['form.factory']->createBuilder('form',
                new Timeline('', ''))
                ->add('title', 'text')
                ->add('intro', 'text')
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $data = $form->getData();

                // do something with the data

                // redirect somewhere
                return $this->redirect('/timeline/created');
            }

            return $this['twig']->render('create.html.twig', [
                'form' => $form->createView(),
            ]);
        });
    }
}
