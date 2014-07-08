<?php
/**
 * Created by PhpStorm.
 * User: SemenetsA
 * Date: 08.07.14
 * Time: 11:28
 */
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;
use Album\Form\AlbumForm;
//use Zend\Form\Annotation\AnnotationBuilder;

class AlbumAnotController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
        ));
    }

    protected function getForm()
    {
     //   $builder    = new AnnotationBuilder();
     //   $entity     = new AlbumAnot();
     //   $form       = $builder->createForm($entity);

        return $form;
    }

    public function savetodb($data)
    {
        //code save to db ....
    }

    public function showformAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
//var_dump($id);
//        die;
        $viewmodel = new ViewModel();
       // $form       = $this->getForm();
        $form = new AlbumForm();
        if ($id > 0) {
            try {
                $album = $this->getAlbumTable()->getAlbum($id);
                $form->bind($album);
                $form->get('submit')->setAttribute('value', 'Edit');
            }
            catch (\Exception $ex) {

            }
        }

        $request = $this->getRequest();

        //disable layout if request by Ajax
        $viewmodel->setTerminal($request->isXmlHttpRequest());

        $is_xmlhttprequest = 1;
        if ( ! $request->isXmlHttpRequest()){
            //if NOT using Ajax
            $is_xmlhttprequest = 0;
            if ($request->isPost()){
                $form->setData($request->getPost());
                if ($form->isValid()){
                    //save to db <span class="wp-smiley emoji emoji-wink" title=";)">;)</span>

                    //$this->savetodb($form->getData());
                    //save data
                    $album = new Album();
                    $album->exchangeArray($form->getData());
                    $this->getAlbumTable()->saveAlbum($album);

                    //update view?
                    return $this->redirect()->toRoute('album');

                    // makes disable renderer
                    //$this->_helper->viewRenderer->setNoRender();
	                //makes disable layout
    	            //$this->_helper->getHelper('layout')->disableLayout();
                    //return $response;
                }
            }
        }

        $viewmodel->setVariables(array(
            'form' => $form,
            // is_xmlhttprequest is needed for check this form is in modal dialog or not
            // in view
            'is_xmlhttprequest' => $is_xmlhttprequest
        ));

        return $viewmodel;
    }

    public function validatepostajaxAction()
    {
       // $form    = $this->getForm();
        $form = new AlbumForm();
        $request = $this->getRequest();
        $response = $this->getResponse();

        $messages = array();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ( ! $form->isValid()) {
                $errors = $form->getMessages();
                foreach($errors as $key=>$row)
                {
                    if (!empty($row) && $key != 'submit') {
                        foreach($row as $keyer => $rower)
                        {
                            //save error(s) per-element that
                            //needed by Javascript
                            $messages[$key][] = $rower;
                        }
                    }
                }
            }

            if (!empty($messages)){
                $response->setContent(\Zend\Json\Json::encode($messages));
            } else {
                //save to db <span class="wp-smiley emoji emoji-wink" title=";)">;)</span>
                $this->savetodb($form->getData());
                $response->setContent(\Zend\Json\Json::encode(array('success'=>1)));
            }
        }

        return $response;
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
}