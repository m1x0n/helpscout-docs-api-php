<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class Site extends DocsModel
{
    public const SITE_STATUS_ACTIVE = 'active';
    public const SITE_STATUS_INACTIVE = 'inactive';

    private ?int $id = null;
    private ?string $status = null;
    private ?string $subDomain = null;
    private ?string $cname = null;
    private bool $hasPublicSite = false;
    private ?string $companyName = null;
    private ?string $title = null;
    private ?string $logoUrl = null;
    private ?int $logoWidth = null;
    private ?int $logoHeight = null;
    private ?string $favIconUrl = null;
    private ?string $touchIconUrl = null;
    private ?string $homeUrl = null;
    private ?string $homeLinkText = null;
    private ?string $bgColor = null;
    private ?string $description = null;
    private bool $hasContactForm = false;
    private ?int $mailboxId = null;
    private ?string $contactEmail = null;
    private ?string $styleSheetUrl = null;
    private ?string $headerCode = null;
    private ?int $createdBy = null;
    private ?int $updatedBy = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    /**
     * @var array|string[]
     */
    private static array $restricted = [
        'id',
        'createdBy',
        'updatedBy',
        'createdAt',
        'updatedAt',
        'companyName'
    ];

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id             = $data->id ?? null;
            $this->status         = $data->status ?? null;
            $this->subDomain      = $data->subDomain ?? null;
            $this->cname          = $data->cname ?? null;
            $this->hasPublicSite  = $data->hasPublicSite ?? false;
            $this->companyName    = $data->companyName ?? null;
            $this->title          = $data->title ?? null;
            $this->logoUrl        = $data->logoUrl ?? null;
            $this->logoWidth      = $data->logoWidth ?? null;
            $this->logoHeight     = $data->logoHeight ?? null;
            $this->favIconUrl     = $data->favIconUrl ?? null;
            $this->touchIconUrl   = $data->touchIconUrl ?? null;
            $this->homeUrl        = $data->homeUrl ?? null;
            $this->homeLinkText   = $data->homeLinkText ?? null;
            $this->bgColor        = $data->bgColor ?? null;
            $this->description    = $data->description ?? null;
            $this->hasContactForm = $data->hasContactForm ?? false;
            $this->mailboxId      = $data->mailboxId ?? null;
            $this->contactEmail   = $data->contactEmail ?? null;
            $this->styleSheetUrl  = $data->styleSheetUrl ?? null;
            $this->headerCode     = $data->headerCode ?? null;
            $this->createdBy      = $data->createdBy ?? null;
            $this->updatedBy      = $data->updatedBy ?? null;
            $this->createdAt      = $data->createdAt ?? null;
            $this->updatedAt      = $data->updatedAt ?? null;
        }
    }

    public function setBgColor(string $bgColor): void
    {
        $this->bgColor = $bgColor;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setCname(string $cname): void
    {
        $this->cname = $cname;
    }

    public function getCname(): ?string
    {
        return $this->cname;
    }

    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setContactEmail(string $contactEmail): void
    {
        $this->contactEmail = $contactEmail;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setFavIconUrl(string $favIconUrl): void
    {
        $this->favIconUrl = $favIconUrl;
    }

    public function getFavIconUrl(): ?string
    {
        return $this->favIconUrl;
    }

    public function setHasContactForm(bool $hasContactForm): void
    {
        $this->hasContactForm = $hasContactForm;
    }

    public function getHasContactForm(): bool
    {
        return $this->hasContactForm;
    }

    public function setHasPublicSite(bool $hasPublicSite): void
    {
        $this->hasPublicSite = $hasPublicSite;
    }

    public function getHasPublicSite(): bool
    {
        return $this->hasPublicSite;
    }

    public function setHeaderCode(string $headerCode): void
    {
        $this->headerCode = $headerCode;
    }

    public function getHeaderCode(): ?string
    {
        return $this->headerCode;
    }

    public function setHomeLinkText(string $homeLinkText): void
    {
        $this->homeLinkText = $homeLinkText;
    }

    public function getHomeLinkText(): ?string
    {
        return $this->homeLinkText;
    }

    public function setHomeUrl(string $homeUrl): void
    {
        $this->homeUrl = $homeUrl;
    }

    public function getHomeUrl(): ?string
    {
        return $this->homeUrl;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLogoHeight(int $logoHeight): void
    {
        $this->logoHeight = $logoHeight;
    }

    public function getLogoHeight(): ?int
    {
        return $this->logoHeight;
    }

    public function setLogoUrl(string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoWidth(int $logoWidth): void
    {
        $this->logoWidth = $logoWidth;
    }

    public function getLogoWidth(): ?int
    {
        return $this->logoWidth;
    }

    public function setMailboxId(int $mailboxId): void
    {
        $this->mailboxId = $mailboxId;
    }

    public function getMailboxId(): ?int
    {
        return $this->mailboxId;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStyleSheetUrl(string $styleSheetUrl): void
    {
        $this->styleSheetUrl = $styleSheetUrl;
    }

    public function getStyleSheetUrl(): ?string
    {
        return $this->styleSheetUrl;
    }

    public function setSubDomain(string $subDomain): void
    {
        $this->subDomain = $subDomain;
    }

    public function getSubDomain(): ?string
    {
        return $this->subDomain;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTouchIconUrl(string $touchIconUrl): void
    {
        $this->touchIconUrl = $touchIconUrl;
    }

    public function getTouchIconUrl(): ?string
    {
        return $this->touchIconUrl;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedBy(int $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function toJson(): string
    {
        return json_encode($this->getAvailableProperties(), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->getAvailableProperties();
    }

    /**
     * @return array<string, mixed>
     */
    private function getAvailableProperties(): array
    {
        $reflector = new \ReflectionClass($this);
        $properties = array_filter($reflector->getProperties(), fn($p): bool => $p->name !== 'restricted');

        $vars = array();

        foreach ($properties as $prop) {
            if (!in_array($prop->name, self::$restricted, true)) {
                $vars[$prop->name] = $this->{"get" . ucfirst($prop->name)}();
            }
        }

        return $vars;
    }
}
