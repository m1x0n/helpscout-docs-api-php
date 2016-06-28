<?php

namespace HelpScoutDocs\Models;

class Site extends DocsModel {

    const SITE_STATUS_ACTIVE = 'active';
    const SITE_STATUS_INACTIVE = 'inactive';

    private $id;
    private $status;
    private $subDomain;
    private $cname;
    private $hasPublicSite;
    private $companyName;
    private $title;
    private $logoUrl;
    private $logoWidth;
    private $logoHeight;
    private $favIconUrl;
    private $touchIconUrl;
    private $homeUrl;
    private $homeLinkText;
    private $bgColor;
    private $description;
    private $hasContactForm;
    private $mailboxId;
    private $contactEmail;
    private $styleSheetUrl;
    private $headerCode;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    private static $restricted = array('id', 'createdBy', 'updatedBy', 'createdAt', 'updatedAt', 'companyName');

    function __construct($data = null) {
        if ($data) {
            $this->id             = isset($data->id)             ? $data->id             : null;
            $this->status         = isset($data->status)         ? $data->status         : null;
            $this->subDomain      = isset($data->subDomain)      ? $data->subDomain      : null;
            $this->cname          = isset($data->cname)          ? $data->cname          : null;
            $this->hasPublicSite  = isset($data->hasPublicSite)  ? $data->hasPublicSite  : null;
            $this->companyName    = isset($data->companyName)    ? $data->companyName    : null;
            $this->title          = isset($data->title)          ? $data->title          : null;
            $this->logoUrl        = isset($data->logoUrl)        ? $data->logoUrl        : null;
            $this->logoWidth      = isset($data->logoWidth)      ? $data->logoWidth      : null;
            $this->logoHeight     = isset($data->logoHeight)     ? $data->logoHeight     : null;
            $this->favIconUrl     = isset($data->favIconUrl)     ? $data->favIconUrl     : null;
            $this->touchIconUrl   = isset($data->touchIconUrl)   ? $data->touchIconUrl   : null;
            $this->homeUrl        = isset($data->homeUrl)        ? $data->homeUrl        : null;
            $this->homeLinkText   = isset($data->homeLinkText)   ? $data->homeLinkText   : null;
            $this->bgColor        = isset($data->bgColor)        ? $data->bgColor        : null;
            $this->description    = isset($data->description)    ? $data->description    : null;
            $this->hasContactForm = isset($data->hasContactForm) ? $data->hasContactForm : null;
            $this->mailboxId      = isset($data->mailboxId)      ? $data->mailboxId      : null;
            $this->contactEmail   = isset($data->contactEmail)   ? $data->contactEmail   : null;
            $this->styleSheetUrl  = isset($data->styleSheetUrl)  ? $data->styleSheetUrl  : null;
            $this->headerCode     = isset($data->headerCode)     ? $data->headerCode     : null;
            $this->createdBy      = isset($data->createdBy)      ? $data->createdBy      : null;
            $this->updatedBy      = isset($data->updatedBy)      ? $data->updatedBy      : null;
            $this->createdAt      = isset($data->createdAt)      ? $data->createdAt      : null;
            $this->createdBy      = isset($data->updatedAt)      ? $data->updatedAt      : null;
        }
    }

    /**
     * @param mixed $bgColor
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
    }

    /**
     * @return mixed
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * @param mixed $cname
     */
    public function setCname($cname)
    {
        $this->cname = $cname;
    }

    /**
     * @return mixed
     */
    public function getCname()
    {
        return $this->cname;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $favIconUrl
     */
    public function setFavIconUrl($favIconUrl)
    {
        $this->favIconUrl = $favIconUrl;
    }

    /**
     * @return mixed
     */
    public function getFavIconUrl()
    {
        return $this->favIconUrl;
    }

    /**
     * @param mixed $hasContactForm
     */
    public function setHasContactForm($hasContactForm)
    {
        $this->hasContactForm = $hasContactForm;
    }

    /**
     * @return mixed
     */
    public function getHasContactForm()
    {
        return $this->hasContactForm;
    }

    /**
     * @param mixed $hasPublicSite
     */
    public function setHasPublicSite($hasPublicSite)
    {
        $this->hasPublicSite = $hasPublicSite;
    }

    /**
     * @return mixed
     */
    public function getHasPublicSite()
    {
        return $this->hasPublicSite;
    }

    /**
     * @param mixed $headerCode
     */
    public function setHeaderCode($headerCode)
    {
        $this->headerCode = $headerCode;
    }

    /**
     * @return mixed
     */
    public function getHeaderCode()
    {
        return $this->headerCode;
    }

    /**
     * @param mixed $homeLinkText
     */
    public function setHomeLinkText($homeLinkText)
    {
        $this->homeLinkText = $homeLinkText;
    }

    /**
     * @return mixed
     */
    public function getHomeLinkText()
    {
        return $this->homeLinkText;
    }

    /**
     * @param mixed $homeUrl
     */
    public function setHomeUrl($homeUrl)
    {
        $this->homeUrl = $homeUrl;
    }

    /**
     * @return mixed
     */
    public function getHomeUrl()
    {
        return $this->homeUrl;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $logoHeight
     */
    public function setLogoHeight($logoHeight)
    {
        $this->logoHeight = $logoHeight;
    }

    /**
     * @return mixed
     */
    public function getLogoHeight()
    {
        return $this->logoHeight;
    }

    /**
     * @param mixed $logoUrl
     */
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * @return mixed
     */
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * @param mixed $logoWidth
     */
    public function setLogoWidth($logoWidth)
    {
        $this->logoWidth = $logoWidth;
    }

    /**
     * @return mixed
     */
    public function getLogoWidth()
    {
        return $this->logoWidth;
    }

    /**
     * @param mixed $mailboxId
     */
    public function setMailboxId($mailboxId)
    {
        $this->mailboxId = $mailboxId;
    }

    /**
     * @return mixed
     */
    public function getMailboxId()
    {
        return $this->mailboxId;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $styleSheetUrl
     */
    public function setStyleSheetUrl($styleSheetUrl)
    {
        $this->styleSheetUrl = $styleSheetUrl;
    }

    /**
     * @return mixed
     */
    public function getStyleSheetUrl()
    {
        return $this->styleSheetUrl;
    }

    /**
     * @param mixed $subDomain
     */
    public function setSubDomain($subDomain)
    {
        $this->subDomain = $subDomain;
    }

    /**
     * @return mixed
     */
    public function getSubDomain()
    {
        return $this->subDomain;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $touchIconUrl
     */
    public function setTouchIconUrl($touchIconUrl)
    {
        $this->touchIconUrl = $touchIconUrl;
    }

    /**
     * @return mixed
     */
    public function getTouchIconUrl()
    {
        return $this->touchIconUrl;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function toJson()
    {
        return json_encode($this->getAvailableProperties());
    }
    
    public function toArray()
    {
        return $this->getAvailableProperties();
    }

    private function getAvailableProperties()
    {
        $reflector = new \ReflectionClass($this);
        $properties = array_filter($reflector->getProperties(), function($p) {
            return $p->name != 'restricted';
        });

        $vars = array();

        foreach($properties as $prop) {
            if (!in_array($prop->name, self::$restricted)) {
                $vars[$prop->name] = $this->{"get" . ucfirst($prop->name)}();
            }
        }

        return $vars;
    }
}