<?php

namespace Jumbo\Client;

interface AssetTransmitter
{
    /**
     * @param AssetUpload $upload
     * @return array
     */
    public function upload(AssetUpload $upload);

    /**
     * @param string $url
     * @return array
     */
    public function download($url);
}
