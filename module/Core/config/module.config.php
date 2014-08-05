<?php
return array(
        'doctrine' => array(
                'driver' => array(
                        'application_entities' => array(
                                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                                'cache' => 'array',
                                'paths' => array(__DIR__ . '/../src/Core/Entity')
                        ),
                        'orm_default' => array(
                                'drivers' => array(
                                        'Core\Entity' => 'application_entities'
                                )
                                ),
                        'cache'=> 'Doctrine\Common\Cache\ArrayCache'),
                        'paths' => array(__DIR__ . '/../src/Core/Entity')
                                ),
        'view_helpers' => array(
                'invokables' => array(
                        'session' => 'Core\View\Helper\Session',
                    //	'homemenus' => 'Core\View\Helper\HomeMenus',
                    //	'firstBanner' => 'Core\View\Helper\FirstBanner',
                    //	'MyHelper' => 'Core\View\Helper\MyHelper',
                        'AlertMessage' => 'Core\View\Helper\Messages'
                ),
        ),
        'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
                array(
                    'type'     => 'phparray',
                    'base_dir' => __DIR__ . '/../language',
                    'pattern'  => '%s.php',
               ),
            ),
        ),
        'service_manager' => array(
            'factories' => array(
                    'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
                    'Session' => function ($sm){
                        return new Zend\Session\Container('SysSession');
                    },
                    'Core\Service\Auth\System' => function ($sm){
                        return new Core\Service\Auth\System();
                    },

                    'Cache' => function ($sm){
                        // incluindo o arquivo config para pegar o cache adapter
                        $config = include __DIR__ . '/../../../config/application.config.php';
                        $cache = Zend\Cache\StorageFactory::factory(array(
                                'adapter' => array(
                                        'name' => $config['cache']['adapter'],
                                        'options' => array(
                                            //     tempo de validade do cache
                                                'ttl' => 1800,
                                            //     adicionando o diretorio data/cache para salvar os caches.
                                                'cacheDir' => __DIR__ . '/../../../data/cache'
                                        ),
                                ),
                                'plugins' => array(
                                          'exception_handler' => array('throw_exceptions' => false),
                                        'Serializer'
                                )
                            )
                        );

                        $cache->clearExpired();

                        return $cache;

                    },
                    'Zend\Log' => function ($sm) {

                        $today= date('Y-m-d');
                        $log = new Zend\Log\Logger();
                        $writer = new Zend\Log\Writer\Stream(__DIR__ . '/../../../data/logs/' . $today .'.log');
                        $log->addWriter($writer);

                        return $log;
                    },

                    'Core\Acl\Builder' => function ($sm) {
                        $builder = new Core\Acl\Builder();

                        return $builder;
                    },

                 )
            )
        );
