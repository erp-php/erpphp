<?php
namespace Core\Test;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Core\Db\TableGateway;

/**
 * Classe pai dos fixtures
 * @category   Core
 * @package    Test
 * @author     Daniel Chaves<daniel@danielchaves.com.br>
 */
abstract class Fixture implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Entidade 
     * @var string
     */
    protected $entity;

    /**
     * Dados da entidade
     * @var array
     */
    protected $data;

    /**
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Retorna uma instância de serviceManager
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Constrói o fixture de acordo com os parâmetros
     * @param  array $data Parâmetros do fixture
     * @return Entity       Objeto criado
     */
    public function build($data = null)
    {
        if (is_array($data)) {
            $this->data = array_merge($this->data, $data);
        }
        
        $object = new $this->entity;
        $object->setData($this->data);

        $this->getServiceManager()->get('Doctrine\Orm\EntityManager')->persist($object);
        $this->getServiceManager()->get('Doctrine\Orm\EntityManager')->flush();

        return $object;
    }
}