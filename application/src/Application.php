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
use VT\Form\NodeType;
use VT\Form\TimelineType;

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

            $timeline = new Timeline();
            $timeline->setTitle($data['title']);
            $timeline->setIntro($data['intro']);

            $nodes = $this['db']->fetchAll(
                'SELECT * FROM nodes where tl_id = ? ORDER BY ordering DESC',
                [
                    (int) $id
                ]
            );

            foreach ($nodes as $data) {
                $node = new Node();
                $node->setIntro($data['intro']);
                $node->setMediaId($data['media_id']);
                $node->setTimestamp(time());
                $node->setBody($data['body']);
                $timeline->addNode($node);
            }

            return new Response(
                $this['serializer']->serialize(
                    $timeline,
                    'json'
                ),
                200,
                [
                    "Content-Type" => $this['request']->getMimeType('json')
                ]
            );
        });

        $this->get('/timeline/create/done', function () {
            return $this['twig']->render('created.html.twig');
        });

        $this->match('/timeline/create/', function (Request $request) {
            $form = $this['form.factory']->createBuilder('form',
                new Timeline('', ''))
                ->add('title', 'text')
                ->add('intro', 'text')
                ->add('nodes', 'collection', ['type' => new NodeType()])
                ->getForm();


            $timeline = new Timeline();
            $node = new Node();

            $timeline->addNode($node);

            $form = $this['form.factory']->createBuilder(new TimelineType(), $timeline)->getForm();;

            $form->handleRequest($request);

            if ($form->isValid()) {
                /** @var Timeline $timeline */
                $timeline = $form->getData();

                $this['db']
                    ->insert('timeline', [
                        'title' => $timeline->getTitle(),
                        'intro' => $timeline->getIntro()
                    ]);

                // redirect somewhere
                return $this->redirect('/timeline/create/done');
            }

            return $this['twig']->render('create.html.twig', [
                'form' => $form->createView(),
            ]);
        })
            ->method('GET|POST');
    }
}
