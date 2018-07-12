<?php
/**
 * Created by PhpStorm.
 * User: danielpett
 * Date: 30/10/2015
 * Time: 14:18
 */

namespace MyVisit\Model;

use Zend\Db\TableGateway\TableGateway;

class VisitsTable
{

    protected $tableGateway;

    protected $table = 'visits';

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchById($id){
        $rowSet = $this->tableGateway->select(array('id' => $id));
        return $rowSet->current();
    }

    public function delete($id){

    }


}