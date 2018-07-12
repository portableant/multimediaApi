<?php

namespace MyVisit\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View;
use Zend;

class IndexController extends AbstractActionController
{

    protected $visitsTable;

    public function indexAction()
    {
        if ($this->params()->fromRoute('id', false)) {
            $data = $this->getTable()->fetchById($this->params()->fromRoute('id'));
            if(!empty($data)) {
                return new ViewModel(array('visits' => $data));
            } else {
                return $this->notFoundAction();
            }
        } else {
            return $this->notFoundAction();
        }
    }

    public function getTable()
    {
        if (!$this->visitsTable) {
            $sm = $this->getServiceLocator();
            $this->visitsTable = $sm->get('MyVisit\Model\VisitsTable');
        }
        return $this->visitsTable;
    }

}

