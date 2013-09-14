<?php
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Doctrine\ORM\EntityManager;


abstract class CoreController extends AbstractActionController
{
	/**
	 * @return Doctrine\ORM\EntityManager
	 */
	protected $em;
	
	
	/**
	 * @return Zend\Log\Logger
	 */
	protected $log;
	
	
	/**
	 * @return Zend\Cache\StorageFactory
	 */
	protected $cache;
	
	
	
	
    /**
     * Returns a Service
     *
     * @param  string $service
     * @return Service
     */
    protected function getService($service)
    {
        return $this->getServiceLocator()->get($service);
    }
   

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }    
    /**
     * Return a EntityManager
     *
     * @return Doctrine\ORM\EntityManager;
     */
    protected function getEntityManager()
    {
    	if ($this->em === null) {
    		$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    	}
    
    	return $this->em;
    }
    
    /**
     * 
     * Return Zend\Log
     * @return Zend\Log\Logger
     * 
     */
    protected function getLog(){
        if ($this->log === null) {
            $this->log = $this->getServiceLocator()->get('Zend\Log');
        }
        
        return $this->log;
    }
    
    
    /**
     *
     * Return Zend\Log
     * @return Zend\Cache\StorageFactory
     *
     */
    protected function getCache(){
        if ($this->cache === null) {
            $this->cache = $this->getServiceLocator()->get('Cache');
        }
    
        return $this->cache;
    }
    
    

    
    
    
    
    
    
    
    
}