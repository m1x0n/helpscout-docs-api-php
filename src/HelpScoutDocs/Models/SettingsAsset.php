<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

class SettingsAsset
{
    public const SETTINGS_ASSET_LOGO = 'logo';
    public const SETTINGS_ASSET_FAVICON = 'favicon';
    public const SETTINGS_ASSET_TOUCHICON = 'touchicon';

    private ?string $assetType = null;
    private ?string $siteId = null;
    private ?string $file = null;
    private ?string $fileLink = null;

    public function getAssetType(): ?string
    {
        return $this->assetType;
    }

    public function setAssetType(string $assetType): void
    {
        $this->assetType = $assetType;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function getFileLink(): ?string
    {
        return $this->fileLink;
    }

    public function setFileLink(string $fileLink): void
    {
        $this->fileLink = $fileLink;
    }

    public function getSiteId(): ?string
    {
        return $this->siteId;
    }

    public function setSiteId(string $siteId): void
    {
        $this->siteId = $siteId;
    }
}
