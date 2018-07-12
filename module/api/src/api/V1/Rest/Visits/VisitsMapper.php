<?php
/**
 * Created by PhpStorm.
 * User: danielpett
 * Date: 04/11/2015
 * Time: 20:38
 */
namespace api\V1\Rest\Visits;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend;
use Zend\Mail;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class VisitsMapper implements ServiceLocatorAwareInterface
{

    protected $adapterMaster;

    protected $adapterSlave;

    protected $tableName = 'visits';

    protected $sqlWrite;

    protected $sqlRead;

    protected $mailservice;

    protected $service_manager;

    public function __construct(AdapterInterface $adapterMaster, AdapterInterface $adapterSlave)
    {
        $this->adapterMaster = $adapterMaster;
        $this->adapterSlave = $adapterSlave;
        $this->sqlWrite = new Sql($adapterMaster);
        $this->sqlRead = new Sql($adapterSlave);
        $this->sqlWrite->setTable($this->tableName);
        $this->sqlRead->setTable($this->tableName);
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_manager = $serviceLocator;
    }

    public function fetchAllWithoutFilter()
    {
        $select = new Select('visits');
        $paginatorAdapter = new DbSelect($select, $this->adapterMaster);
        $collection = new VisitsCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchAll($params)
    {
        $select = new Select('visits');
        $select->order(array('created ASC'));
        $resultSet = new HydratingResultSet;
        $resultSet->setObjectPrototype(new VisitsEntity());
        $paginatorAdapter = new DbSelect($select, $this->adapterMaster, $resultSet);
        $collection = new VisitsCollection($paginatorAdapter);
        return $collection;
    }

    public function fetchOne($albumId)
    {
        $sql = 'SELECT * FROM visits WHERE id = ?';
        $resultset = $this->adapterSlave->query($sql, array($albumId));
        $data = $resultset->toArray();
        if (!$data) {
            return false;
        }
        $entity = new VisitsEntity();
        $entity->populate($data[0]);
        return $entity;
    }

    /** Save the data submitted via the API POST into DB
     * @return \VisitsEntity
     * @param object $data
     */
    public function save($data)
    {
        $raw = get_object_vars($data);
        if ($raw['subscribed'] === 'true') {
            $value = 1;
        } else {
            $value = 0;
        }
        // Create payload etc
        $json = array(
            'payload' => json_encode($raw),
            'email' => $raw['email'],
            'stops' => json_encode($raw['stops']),
            'started' => $raw['started'],
            'ended' => $raw['ended'],
            'locale' => $raw['locale'],
            'subscribed' => $value
        );
        // Sort out insertion
        $tableToBeInserted = new Zend\Db\TableGateway\TableGateway('visits', $this->adapterMaster);
        // Condition about email
        $tableToBeInserted->insert($json);
        // Populate entity
        $entity = new VisitsEntity();
        $api['email'] = $json['email'];
        $api['subscribed'] = $json['subscribed'];
        $api['stops'] = $json['stops'];
        $api['started'] = $json['started'];
        $api['ended'] = $json['ended'];
        $api['created'] = new \DateTime();
        $api['id'] = $this->adapterMaster->getDriver()->getLastGeneratedValue();
        $entity->populate($api);
        // Create email
        $emailData = $json;
        $emailData['id'] = $api['id'];
        $this->sendMail($emailData);
        return $entity;
    }

    public function sendMail($json)
    {
        $mailService = $this->getServiceLocator()->get('AcMailer\Service\MailService');
        $mailService->setTemplate('api/emails/myvisit.phtml',
            [
                'charset' => 'utf-8',
                'date' => date('Y-m-d'),
                'visits' => $json['stops'],
                'locale' => $json['locale'],
                'id' => $json['id']
            ]
        );
        $message = $mailService->getMessage();
        $message->addTo($json['email']);
        $mailService->send();
    }

    public function getServiceLocator()
    {
        return $this->service_manager;
    }

    public function delete($id)
    {
        $delete = $this->sqlWrite->delete();
        $delete->where(array('id' => $id));
        $statement = $this->sqlWrite->prepareStatementForSqlObject($delete);
        $statement->execute();
        return true;
    }
}