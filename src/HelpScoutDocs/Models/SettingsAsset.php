<?php

namespace HelpScoutDocs\Models;

class SettingsAsset
{
    const SETTINGS_ASSET_LOGO = 'logo';
    const SETTINGS_ASSET_FAVICON = 'favicon';
    const SETTINGS_ASSET_TOUCHICON = 'touchicon';

    /**
     * @var string
     */
    private $assetType;

    /**
     * @var string
     */
    private $siteId;

    /**
     * @var string
     */
    private $file;
    
    /**
     * @var
     */
    private $fileLink;

    /**
     * @return string
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * @param string $assetType
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFileLink()
    {
        return $this->fileLink;
    }

    /**
     * @param mixed $fileLink
     */
    public function setFileLink($fileLink)
    {
        $this->fileLink = $fileLink;
    }

    /**
     * @return string
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param string $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }
}