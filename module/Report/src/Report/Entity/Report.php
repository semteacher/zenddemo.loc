<?php
//namespace Report\Model;

// class Report
// {
//     public $id;
//     public $repname;
//     public $reptitle;


// }

namespace Report\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
* A Report.
*
* @ORM\Entity
* @ORM\Table(name="report")
* @property string $repname
* @property string $reptitle
* @property int $id
*/
class Report implements InputFilterAwareInterface
{
    protected $inputFilter;

    /**
* @ORM\Id
* @ORM\Column(type="integer");
* @ORM\GeneratedValue(strategy="AUTO")
*/
    protected $id;

    /**
* @ORM\Column(type="string")
*/
    protected $repname;

    /**
* @ORM\Column(type="string")
*/
    protected $reptitle;

    /**
* Magic getter to expose protected properties.
*
* @param string $property
* @return mixed
*/
    public function __get($property)
    {
        return $this->$property;
    }

    /**
* Magic setter to save protected properties.
*
* @param string $property
* @param mixed $value
*/
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
* Convert the object to an array.
*
* @return array
*/
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
* Populate from an array.
*
* @param array $data
*/
    public function populate($data = array())
    {
        $this->id = $data['id'];
        $this->artist = $data['repname'];
        $this->title = $data['title'];
    }
    
    //??? from the past
     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->repname = (!empty($data['repname'])) ? $data['repname'] : null;
         $this->reptitle  = (!empty($data['reptitle'])) ? $data['reptitle'] : null;
     }    

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'repname',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'reptitle',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}