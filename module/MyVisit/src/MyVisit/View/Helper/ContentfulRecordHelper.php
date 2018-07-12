<?php
/**
 * Created by PhpStorm.
 * User: danielpett
 * Date: 16/11/2015
 * Time: 14:06
 */

namespace MyVisit\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Incraigulous\ContentfulSDK\DeliverySDK;
use Zend;
use Zend\Cache;
use Zend\Config\Config as ZfConfig;

class ContentfulRecordHelper extends AbstractHelper
{

    /** @var $_sysID */
    public $_sysID;

    /** @var $_assets */
    public $_assets;

    /** @var $_sdk */
    public $_sdk;

    /** @var $_locale */
    public $_locale;

    /** @var $_cache */
    public $_cache;

    /** Return the view helper
     * @return ContentfulRecordHelper
     */
    public function contentfulRecordHelper()
    {
        return $this;
    }

    /** Send the html to the view, using a view partial
     * @return string
     */
    public function __toString()
    {
        return $this->view->partial('asset.phtml', array('data' => $this->getContentful())
        );
    }

    /** Get data from contentful
     * @return array
     */
    public function getContentful()
    {
        $key = md5($this->getSysID() . $this->getLocale());
        if (!$this->getCache()->hasItem($key)) {
            $data = $this->getSdk()
                ->entries()
                ->limitByType('TfgfKWqIUKw6KK2OMCw0M')
                ->where('sys.id', '=', $this->getSysID())
                ->where('locale', '=', $this->getLocale())
                ->includeLinks($this->getAssets())
                ->get();
            $this->getCache()->setItem($key, $data);
        } else {
            $data = $this->getCache()->getItem($key);
        }
        $parsed = array();
        $parsed['title'] = $data['items'][0]['fields']['title'];
        $parsed['stop'] = $data['items'][0]['fields']['number'];
        $parsed['cultureID'] = $data['items'][0]['fields']['cultureArea']['sys']['id'];
        $parsed['culture'] = $this->getCultureArea($data['items'][0]['fields']['cultureArea']['sys']['id']);
        $parsed['thumbnail'] = $this->getThumbnail($data['items'][0]['fields']['stopThumbnail']['sys']['id']);
        $parsed['geo'] = $this->getGeo($data['items'][0]['fields']['stopLocation']['sys']['id']);
        $parsed['large'] = $this->getImages($data['items'][0]['fields']['images'][0]['sys']['id']);
        return $parsed;
    }

    /** Get the system ID
     * @return mixed
     */
    public function getSysID()
    {
        return $this->_sysID;
    }

    /** Set the system ID
     * @param mixed $sysID
     * @return ContentfulRecordHelper
     */
    public function setSysID($sysID)
    {
        $this->_sysID = $sysID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->_locale;
    }

    /** Set the locale
     * @param mixed $locale
     * @return ContentfulRecordHelper
     */
    public function setLocale($locale)
    {
        $this->_locale = $locale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCache()
    {
        $this->_cache = \Zend\Cache\StorageFactory::factory($this->view->configHelp()->cache->toArray());
        return $this->_cache;
    }

    /** Get the SDK for contentful using config keys
     * @return mixed
     */
    public function getSdk()
    {

        $this->_sdk = new DeliverySDK(
            $this->_space = $this->view->configHelp()->contentful->token,
            $this->_space = $this->view->configHelp()->contentful->space
        );
        return $this->_sdk;
    }

    /** Determine whether to get extended data for assets
     * @return mixed
     */
    public function getAssets()
    {
        return $this->_assets;
    }

    /** Set whether to get Assets back
     * @param mixed $assets
     * @return ContentfulRecordHelper
     */
    public function setAssets($assets)
    {
        $this->_assets = $assets;
        return $this;
    }

    public function getCultureArea($id)
    {
        $key = md5($id . $this->getLocale());
        if (!$this->getCache()->hasItem($key)) {
            $data = $this->getSdk()->entries()->find($id)->where('locale', '=', $this->getLocale())->get();
        } else {
            $data = $this->getCache()->getItem($key);
        }
        return $data['fields'];
    }

    public function getThumbnail($id)
    {
        $key = md5($id . $this->getLocale());
        if (!$this->getCache()->hasItem($key)) {
            $data = $this->getSdk()->assets()->find($id)->get();
            $this->getCache()->setItem($key, $data);

        } else {
            $data = $this->getCache()->getItem($key);
        }
        return $data['fields'];
    }

    public function getImages($id)
    {
        $key = md5($id . $this->getLocale());
        if (!$this->getCache()->hasItem($key)) {
            $data = $this->getSdk()->assets()->find($id)->get();
            $this->getCache()->setItem($key, $data);

        } else {
            $data = $this->getCache()->getItem($key);
        }
        return $data['fields'];
    }

    public function getGeo($id)
    {
        $key = md5($id . $this->getLocale());
        if (!$this->getCache()->hasItem($key)) {
            $data = $this->getSdk()->entries()->find($id)->get();
            $this->getCache()->setItem($key, $data);

        } else {
            $data = $this->getCache()->getItem($key);
        }
        return $data['fields'];
    }
}