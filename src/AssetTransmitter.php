<?php

namespace Jumbo\Client;

interface AssetTransmitter
{
    public function upload(AssetUpload $upload): void;

    public function download(string $url): array;
}
