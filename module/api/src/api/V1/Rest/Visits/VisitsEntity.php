<?php
namespace api\V1\Rest\Visits;

use Zend;

class VisitsEntity
{

    public $id;

    public $payload;

    public $created;

    public $stops;

    public $email;

    public $started;

    public $ended;

    public $locale;

    public $subscribed;


    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->payload = (!empty($data['payload'])) ? $data['payload'] : null;
        $this->created = (!empty($data['created'])) ? $data['created'] : null;
        $this->stops = (!empty($data['stops'])) ? $data['stops'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->locale = (!empty($data['locale'])) ? $data['locale'] : null;
        $this->started = (!empty($data['started'])) ? $data['started'] : null;
        $this->ended = (!empty($data['ended'])) ? $data['ended'] : null;
        $this->subscribed = (!empty($data['subscribed'])) ? $data['subscribed'] : null;
    }


    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function populate($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
