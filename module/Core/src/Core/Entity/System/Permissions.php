<?php
namespace Core\Entity\System;

use Core\Entity\CoreEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Users
 *
 * @ORM\Entity
 * @ORM\Table(name="tblsystem_permissions")
 */
class Permissions extends CoreEntity
{
	

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	
	protected $id;
	
	
	/**
	* @ORM\Column(type="integer")
	* @ORM\OneToMany(targetEntity="Core\Entity\System\Permissions", mappedBy="idResource", cascade={"all"})
	* @var integer
	*/
	
	protected $idRole;
	
	
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\OneToMany(targetEntity="Core\Entity\System\Resources", mappedBy="id",cascade={"ALL"})
	 * @var integer
	 */
	
	protected $idResource;
	
	
	/**
	 * @ORM\Column(type="string",length=50)
	 * @var string
	 */
	
	protected $permission;

	
	
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getIdRole() {
		return $this->idRole;
	}
	
	public function setIdRole($idRole) {
		$this->idRole = $idRole;
		return $this;
	}
	
	public function getIdResource() {
		return $this->idResource;
	}
	
	public function setIdResource($idResource) {
		$this->idResource = $idResource;
		return $this;
	}


	public function getPermission() {
		return $this->permission;
	}
	
	public function setPermission($permission) {
		$this->permission = $permission;
		return $this;
	}
		
	
	
	public function getInputFilter()
	{
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter();
	
			$factory = new InputFactory();
	
			$inputFilter->add($factory->createInput(array(
					'name' => 'id',
					'required '=> true,
					'filters' => array(
							array('name' => 'Int')
					),
	
			)));
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'idRole',
					'required' => true,
					'filters' => array(
							array('name' => 'Int')
					),
			)));
			
			
			$inputFilter->add($factory->createInput(array(
					'name'     => 'idResource',
					'required' => true,
					'filters' => array(
							array('name' => 'Int')
					),
			)));
	
			
				
		}
	}
	
	
	
	
	
	
	
}