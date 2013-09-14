<?php
namespace Core\Entity\System;

use Core\Entity\CoreEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Users
 *
 * @ORM\Entity
 * @ORM\Table(name="tblsystem_roles")
 */
class Roles extends CoreEntity
{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	
	protected $id;
	
	/**
	 * @ORM\Column(type="string",length=100)
	 * @var string
	 */
	
	protected $roleName;
	
	
	/**
	 * @ORM\Column(type="string",length=100)
	 * @var string
	 */
	
	protected $roleParent;

	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	public function getRoleName() {
		return $this->roleName;
	}
	
	public function setRoleName($roleName) {
		$this->roleName = $roleName;
		return $this;
	}
	
	public function getRoleParent() {
		if($this->roleParent){
			return $this->roleParent;
		}else{
			return null;
		}
	}
	
	public function setRoleParent($roleParent) {
		$this->roleParent = $roleParent;
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
					'name'     => 'roleName',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));
	
			$inputFilter->add($factory->createInput(array(
					'name'     => 'roleParent',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			)));
	
			
		}
	}
	
	
	
	
}