<?php

namespace Core\Test;

use Zend\Db\Adapter\Adapter;
use Core\Db\TableGateway;
use Zend\Mvc\Application;
use Zend\Di\Di;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;

/**
 * Classe pai dos testes
 * @category   Core
 * @package    Test
 * @author     Daniel Chaves<daniel@danielchaves.com.br>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * O ServiceManager usado pelos testes
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * Uma instância da aplicação
     * @var Zend\Mvc\Application
     */
    protected $application;

    /**
     * Rotas dos módulos, usadas pelos testes de controller
     * @var array
     */
    protected $routes;

    /**
     * Variável com as configurações 
     * @var array
     */
    protected $config;

    /**
     * EntityManager  
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * Variável que configura se devem ser criadas as chaves estrangeiras das tabelas
     * @var boolean
     */
    protected $createForeignKeys = true;

    /**
     * Faz o setup dos testes. Executado antes de cada teste
     * @return void
     */
    public function setup()
    {
        $env = getenv('ENV');
        //o jenkins tem configurações especiais
        if (!$env || $env != 'jenkins') {
            putenv("ENV=testing");
            $env = 'testing';
        }
       
        putenv('PROJECT_ROOT=' . __DIR__ . '/../../../../../');
        parent::setup();

        //arquivo de configuração da aplicação
        $config = include __DIR__ . '/../../../../../config/tests.config.php';
        $config['module_listener_options']['config_static_paths'] = array();

        //cria um novo ServiceManager
        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                isset($config['service_manager']) ? $config['service_manager'] : array()
            )
        );

        //configura os serviços básicos no ServiceManager
        $this->serviceManager->setService('ApplicationConfig', $config);
        $this->serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

        //verifica se os módulos possuem rotas configuradas e carrega elas para serem usadas pelo ControllerTestCase
        $moduleManager = $this->serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
        $this->routes = array();
        $testConfig = false;
        //carrega as rotas dos módulos
        foreach ($moduleManager->getLoadedModules() as $m) {
            $moduleConfig = $m->getConfig();
            $this->getModuleRoutes($moduleConfig);
            
            $moduleName = explode('\\', get_class($m));
            $moduleName = $moduleName[0];
            //verifica se existe um arquivo de configuração específico no módulo para testes
            if (file_exists(getcwd() . '/module/' . ucfirst($moduleName) . '/config/test.config.php')) {
                $testConfig = include getcwd() . '/module/' . ucfirst($moduleName) . '/config/test.config.php';
                array_unshift($config['module_listener_options']['config_static_paths'], $testConfig[$env]);
            }
        }

        if (!$testConfig) {
            $config['module_listener_options']['config_static_paths'] = array(getcwd() . '/config/tests.config.php');
        }
        $this->config = include $config['module_listener_options']['config_static_paths'][0];
        $this->serviceManager->setAllowOverride(true);

        //instancia a aplicação e configura os eventos e rotas
        $this->application = $this->serviceManager->get('Application');
        $this->event = new MvcEvent();
        $this->event->setTarget($this->application);
        $this->event->setApplication($this->application)
                ->setRequest($this->application->getRequest())
                ->setResponse($this->application->getResponse())
                ->setRouter($this->serviceManager->get('Router'));

        $this->entityManager = $this->getEntityManager();
        $this->dropDatabase();
        $this->createDatabase();
    }

    protected function getModuleRoutes($moduleConfig)
    {
        if (isset($moduleConfig['router'])) {
            foreach ($moduleConfig['router']['routes'] as $key => $name) {
                $this->routes[$key] = $name;
            }
        }
    }
    
    /**
     * Retorna uma instância de Service
     *
     * @param  string $service
     * @return Service
     */
    protected function getService($service)
    {
        return $this->serviceManager->get($service);
    }

    /**
     * Retorna uma instância de Fixgure
     *
     * @param  string $fixture
     * @return Fixture
     */
    protected function getFixture($fixture)
    {
        return $this->serviceManager->get($fixture);
    }

    /**
     * Cria a database de testes
     * @return void
     */
    public function createDatabase()
    {

        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($classes);
    }

    /**
     * Remove a database de testes
     * @return void
     */
    public function dropDatabase()
    {
        
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($classes);
        
        
    }

    /**
     * Recupera o EntityManager dos testes
     * @return EntityManager
     */
    private function getEntityManager()
    {
        if ($this->entityManager) {
            return $this->entityManager;
        }
        $this->em = $this->serviceManager->get('Doctrine\ORM\EntityManager');
        
        return $this->em;
    }
    
    protected function createRoles()
    {
        
        $rolenames = array(array('visitante',''),array('sysuser','visitante'),array('sysadmin','sysuser'));
        foreach($rolenames as $rolename){
           
        $roles = new \Core\Entity\System\Roles();
        $roles->setRoleName($rolename[0]);
        $roles->setRoleParent($rolename[1]);
        $this->getEntityManager()->persist($roles);
        $this->getEntityManager()->flush();
        
        }
        
        
        
    }
    
    protected function createResources()
    {
        
    }
}