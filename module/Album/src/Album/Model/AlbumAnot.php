<?php
namespace Album\Model;

 // Add these import statements
// use Zend\InputFilter\InputFilter;
// use Zend\InputFilter\InputFilterAwareInterface;
// use Zend\InputFilter\InputFilterInterface;
 use Zend\Form\Annotation;

 /**
  * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
  * @Annotation\Name("AlbumAnot")
  */
 class AlbumAnot
 {
     /**
      * @Annotation\Exclude()
      */
     public $id;
     /**
      * @Annotation\Type("Zend\Form\Element\Text")
      * @Annotation\Required({"required":"true" })
      * @Annotation\Filter({"name":"StripTags"})
      * @Annotation\Filter({"name":"StringTrim"})
      * @Annotation\Validator({"name":"StringLength", "options":{"min":"1", "max":"100", "encoding":"UTF-8"}})
      * @Annotation\Options({"label":"Artist Name:"})
      */
     public $artist;
     /**
      * @Annotation\Type("Zend\Form\Element\Text")
      * @Annotation\Required({"required":"true" })
      * @Annotation\Filter({"name":"StripTags"})
      * @Annotation\Filter({"name":"StringTrim"})
      * @Annotation\Validator({"name":"StringLength", "options":{"min":"1", "max":"100", "encoding":"UTF-8"}})
      * @Annotation\Options({"label":"Album Title:"})
      */
     public $title;
     /**
      * @Annotation\Type("Zend\Form\Element\Submit")
      * @Annotation\Attributes({"value":"Submit"})
      */
     public $submit;
 }