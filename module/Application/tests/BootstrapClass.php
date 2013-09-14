<?php
namespace ApplicationTest;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Db\Adapter\Adapter;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;

/**
 * Daniel Chaves<daniel@danielchaves.com.br>
 */
class BootstrapClass
{
    /**
     * Retorna o nome do módulo
     * @return string O nome do módulo no SO
     */
    public static function getModuleName()
    {
        return 'Application';
    }

    /**
     * Retorna o caminho do módulo
     * @return string O caminho do módulo no SO
     */
    public static function getModulePath()
    {
        return __DIR__ . '/../../../module/' . \Bootstrap::getModuleName();
    }

    public static function execute()
    {
        chdir(dirname(__DIR__ . '/../../../..'));

        include 'init_autoloader.php';

        define('ZF2_PATH', realpath('vendor/zendframework/zendframework/library'));

        $path = array(
            ZF2_PATH,
            get_include_path(),
        );
        set_include_path(implode(PATH_SEPARATOR, $path));

        require_once  'Zend/Loader/AutoloaderFactory.php';
        require_once  'Zend/Loader/StandardAutoloader.php';

        // setup autoloader
        AutoloaderFactory::factory(
            array(
                'Zend\Loader\StandardAutoloader' => array(
                    StandardAutoloader::AUTOREGISTER_ZF => true,
                    StandardAutoloader::ACT_AS_FALLBACK => false,
                    StandardAutoloader::LOAD_NS => array(
                        'Core' => __DIR__ . '/../../../module/Core/src/Core'
                    )
                )
            )
        );
    }
}