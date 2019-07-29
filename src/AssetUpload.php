<?php

namespace Jumbo\Client;

interface AssetUpload
{
    public function getName(): string;

    public function getPurpose(): string;

    public function getType(): string;

    public function getContents(): string;

    public function getMimeType(): ?string;

    public function setMimeType(?string $mimeType): void;

    public function getId(): ?string;

    public function setId(?string $id): void;

    public function getUploadUrl(): ?string;

    public function setUploadUrl(?string $uploadUrl): void;

    public function getUrl(): ?string;

    public function setUrl(?string $url): void;

    public function getSize(): ?int;

    public function setSize(?int $size): void;

    public function getDescription(): ?string;

    public function getLanguages(): array;

    public function getTags(): array;

    public function getArticles(): array;

    public function isArchived(): bool;

    public function getAcl(): string;

    public function setAcl(string $acl);

    public function getEncryption(): string;

    public function setEncryption(string $encryption);
}
