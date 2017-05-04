<?php

namespace Jumbo\Client;

interface AssetUpload
{
    /**
     * @return string
     */
    public function getFilename();

    /**
     * @param string $filename
     */
    public function setFilename($filename);

    /**
     * @return string|null
     */
    public function getMimetype();

    /**
     * @param string|null $mimetype
     */
    public function setMimetype($mimetype);

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
    public function getUrl();

    /**
     * @param string|null $url
     */
    public function setUrl($url);
}
