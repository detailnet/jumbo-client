<?php

namespace Jumbo\Client;

class AssetUploadFromContents implements
    AssetUpload
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $purpose;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $contents;

    /**
     * @var string|null
     */
    protected $mimeType;

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $uploadUrl;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var integer|null
     */
    protected $size;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var array
     */
    protected $languages = array();

    /**
     * @var array
     */
    protected $tags = array();

    /**
     * @var array
     */
    protected $articles = array();

    /**
     * @var boolean
     */
    protected $archived = false;

    /**
     * @var string
     */
    protected $acl = 'private';

    /**
     * @var string
     */
    protected $encryption = 'AES256';

    /**
     * @param string $name
     * @param string $purpose
     * @param string $type
     * @param string $contents
     */
    public function __construct($name, $purpose, $type, $contents)
    {
        $this->purpose = $purpose;
        $this->name = $name;
        $this->type = $type;
        $this->contents = $contents;
        $this->setSize(strlen($contents));
    }

    /**
     * @return string
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return string|null
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param string|null $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getUploadUrl()
    {
        return $this->uploadUrl;
    }

    /**
     * @param string|null $uploadUrl
     */
    public function setUploadUrl($uploadUrl)
    {
        $this->uploadUrl = $uploadUrl;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return integer|null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param integer|null $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param array $languages
     */
    public function setLanguages(array $languages)
    {
        $this->languages = $languages;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param array $articles
     */
    public function setArticles(array $articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    /**
     * @return string
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * @param string $acl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
    }

    /**
     * @return string
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * @param string $encryption
     */
    public function setEncryption($encryption)
    {
        $this->encryption = $encryption;
    }
}

