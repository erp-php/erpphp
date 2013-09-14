<?php
namespace Core\Acl;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class Builder implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        //return $this;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }



    /**
     * Constroi a ACL de acordo com as entities
     * @see Core\Entity\System\Roles
     * @todo Inclusao das ACLS no Cache
     * @return Acl
     */
    public function build()
    {
    	$em = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
    	$roles = $em->getRepository('Core\Entity\System\Roles')->findAll();
    	$resources = $em->getRepository('Core\Entity\System\Resources')->findAll();


        $acl = new Acl();
        foreach ($roles as $role) {
            $acl->addRole(new Role($role->getRoleName()), $role->getRoleParent());
        }
        foreach ($resources as $r) {
            $acl->addResource(new Resource($r->getResourceName()));
        }
        foreach($roles as $role){
        	$rolename = $role->getRoleName();
        	$allowed = $em->getRepository('Core\Entity\System\Permissions')->findBy(array('idRole'=>$role->getId(),'permission'=>'allow'));
        	foreach($allowed as $allow){
        		$resources = $em->getRepository('Core\Entity\System\Resources')->find($allow->getIdResource());
        		$acl->allow($rolename, $resources->getResourceName());

        	}

        	$denyed = $em->getRepository('Core\Entity\System\Permissions')->findBy(array('idRole'=>$role->getId(),'permission'=>'deny'));
        	foreach($denyed as $deny){
        		$resources = $em->getRepository('Core\Entity\System\Resources')->find($deny->getIdResource());
        		$acl->deny($rolename, $resources->getResourceName());

        	}

        }



        return $acl;
    }
}