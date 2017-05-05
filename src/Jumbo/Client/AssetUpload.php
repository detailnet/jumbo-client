<?php

namespace Jumbo\Client;

interface AssetUpload
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getPurpose();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getContents();

    /**
     * @return string|null
     */
    public function getMimeType();

    /**
     * @param string|null $mimeType
     */
    public function setMimeType($mimeType);

    /**
     * @return string|null
     */
    public function getId();

    /**
     * @param string|null $id
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getUploadUrl();

    /**
     * @param string|null $uploadUrl
     */
    public function setUploadUrl($uploadUrl);

    /**
     * @return string|null
     */
    public function getUrl();

    /**
     * @param string|null $url
     */
    public function setUrl($url);

    /**
     * @return integer|null
     */
    public function getSize();

    /**
     * @param integer|null $size
     */
    public function setSize($size);

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @return array
     */
    public function getLanguages();

    /**
     * @return array
     */
    public function getTags();

    /**
     * @return array
     */
    public function getArticles();

    /**
     * @return boolean
     */
    public function isArchived();

    /**
     * @return string
     */
    public function getAcl();

    /**
     * @param string $acl
     */
    public function setAcl($acl);

    /**
     * @return string
     */
    public function getEncryption();

    /**
     * @param string $encryption
     */
    public function setEncryption($encryption);
}
