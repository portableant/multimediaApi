<?php
/**
 * Created by PhpStorm.
 * User: danielpett
 * Date: 30/10/2015
 * Time: 14:16
 */
namespace MyVisit\Model;

class Visits
{

    public $id;

    public $payload;

    public $started;

    public $ended;

    public $stops;

    public $email;

    public $locale;

    public $created;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Visits
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @param mixed $started
     * @return Visits
     */
    public function setStarted($started)
    {
        $this->started = $started;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * @param mixed $ended
     * @return Visits
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStops()
    {
        return $this->stops;
    }

    /**
     * @param mixed $stops
     * @return Visits
     */
    public function setStops($stops)
    {
        $this->stops = $stops;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Visits
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     * @return Visits
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     * @return Visits
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     * @return Visits
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }


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
    }
}