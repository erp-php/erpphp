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
 * @ORM\Table(name="tblsystem_resources")
 */
class Resources extends CoreEntity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="Core\Entity\System\Permissions", mappedBy="idResource", cascade={"all"})
     * @ORM\OrderBy({"pos" = "ASC"})
     * @var integer
     */

    protected $id;

    /**
     * @ORM\Column(type="string",length=100)
     * @var string
     */

    protected $resourceName;

    /**
     * @ORM\Column(type="text")
     * @var string
     */

    protected $ResourceDescription;

    public function getId()
    {
        return $this->id;
    }

    public function setId(integer $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getResourceName()
    {
        return $this->resourceName;
    }

    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;

        return $this;
    }

    public function getResourceDescription()
    {
        return $this->ResourceDescription;
    }

    public function setResourceDescription($ResourceDescription)
    {
        $this->ResourceDescription = $ResourceDescription;

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
                    'name'     => 'resourceName',
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
                    'name'     => 'resourceDescription',
                    'required' => true,
                    'filters'  => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                    ),
            )));

        }
    }

}
