<?php
/**
 * Created by PhpStorm.
 * User: danielpett
 * Date: 16/11/2015
 * Time: 14:06
 */

namespace MyVisit\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend;
use Zend\Cache;
use Zend\Config\Config as ZfConfig;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;

class StreetViewHelper extends AbstractHelper
{

    public $_cache;

    public $_lat = '51.5191922';

    public $_lon = '-0.1282743';

    public $_size = '600x300';

    public $_heading = 0;

    public $_scale = 2;

    public $_pitch = 0;

    public $_apiKey;

    protected $google = 'https://maps.googleapis.com/maps/api/streetview?';

    /**
     * @return mixed
     */
    public function getCache()
    {
        $this->_cache = \Zend\Cache\StorageFactory::factory($this->view->configHelp()->cache->toArray());
        return $this->_cache;
    }

    /**
     * @param mixed $cache
     * @return ContentfulRecordHelper
     */
    public function setCache($cache)
    {
        $this->_cache = $cache;
        return $this;
    }

    public function streetViewHelper()
    {
        return $this;
    }

    public function __toString()
    {
        return $this->getGoogle() . http_build_query($this->buildQuery());
    }

    public function getImage()
    {
        $adapter = new Curl();

        $adapter->setOptions(array(
            'curloptions' => array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => FALSE,
            )
        ));
        $client = new Client($this->getGoogle());
        $client->setAdapter($adapter);
        $client->setMethod('GET');
        $client->setParameterGet($this->buildQuery());
        $response = $client->send($client->getRequest());
        return $response->getBody();
    }

    /**
     * @return string
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * @param string $google
     * @return StreetViewHelper
     */
    public function setGoogle($google)
    {
        $this->google = $google;
        return $this;
    }

    public function buildQuery()
    {
        $params = array(
            'size' => $this->getSize(),
            'location' => $this->getLat() . ',' . $this->getLon(),
            'heading' => $this->getHeading(),
            'pitch' => $this->getPitch(),
            'scale' => $this->getScale(),
            'key' => $this->getApiKey()
        );
        return $params;

    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * @param mixed $size
     * @return StreetViewHelper
     */
    public function setSize($size)
    {
        $this->_size = $size;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->_lat;
    }

    /**
     * @param mixed $lat
     * @return StreetViewHelper
     */
    public function setLat($lat)
    {
        $this->_lat = $lat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLon()
    {
        return $this->_lon;
    }

    /**
     * @param mixed $lon
     * @return StreetViewHelper
     */
    public function setLon($lon)
    {
        $this->_lon = $lon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeading()
    {
        return $this->_heading;
    }

    /**
     * @param mixed $heading
     * @return StreetViewHelper
     */
    public function setHeading($heading)
    {
        $this->_heading = $heading;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPitch()
    {
        return $this->_pitch;
    }

    /**
     * @param mixed $pitch
     * @return StreetViewHelper
     */
    public function setPitch($pitch)
    {
        $this->_pitch = $pitch;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScale()
    {
        return $this->_scale;
    }

    /**
     * @param mixed $scale
     */
    public function setScale($scale)
    {
        $this->_scale = $scale;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        $this->_apiKey = $this->view->configHelp()->google->streetViewApiKey;
        return $this->_apiKey;
    }

    /**
     * @param mixed $apiKey
     * @return StreetViewHelper
     */
    public function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;
        return $this;
    }


}