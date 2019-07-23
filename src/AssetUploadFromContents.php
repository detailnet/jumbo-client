<?php

namespace Jumbo\Client;

class AssetUploadFromContents implements
    AssetUpload
{
    /** @var string */
    private $name;

    /** @var string */
    private $purpose;

    /** @var string */
    private $type;

    /** @var string */
    private $contents;

    /** @var string|null */
    private $mimeType;

    /** @var string|null */
    private $id;

    /** @var string|null */
    private $uploadUrl;

    /** @var string|null */
    private $url;

    /** @var integer|null */
    private $size;

    /** @var string|null */
    private $description;

    /** @var array */
    private $languages = [];

    /** @var array */
    private $tags = [];

    /** @var array */
    private $articles = [];

    /** @var boolean */
    private $archived = false;

    /** @var string */
    private $acl = 'private';

    /** @var string */
    private $encryption = 'AES256';

    public function __construct(string $name, string $purpose, string $type, string $contents)
    {
        $this->purpose = $purpose;
        $this->name = $name;
        $this->type = $type;
        $this->contents = $contents;
        $this->setSize(strlen($contents));
    }

    public function getPurpose(): string
    {
        return $this->purpose;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getUploadUrl(): ?string
    {
        return $this->uploadUrl;
    }

    public function setUploadUrl(?string $uploadUrl): void
    {
        $this->uploadUrl = $uploadUrl;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): void
    {
        $this->languages = $languages;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function setArticles(array $articles): void
    {
        $this->articles = $articles;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): void
    {
        $this->archived = $archived;
    }

    public function getAcl(): string
    {
        return $this->acl;
    }

    public function setAcl(string $acl): void
    {
        $this->acl = $acl;
    }

    public function getEncryption(): string
    {
        return $this->encryption;
    }

    public function setEncryption(string $encryption): void
    {
        $this->encryption = $encryption;
    }
}
