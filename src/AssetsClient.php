<?php

namespace Jumbo\Client;

use Jumbo\Client\Response;

/**
 * Jumbo Assets Service client
 *
 * @method Response\ListResponse listAssets(array $params = [])
 * @method Response\ListResponse listAssetCollections(array $params = [])
 * @method Response\ListResponse listPurposes(array $params = [])
 */
class AssetsClient extends JumboClient
{
    /** @var AssetTransmitter|null */
    private $assetTransmitter;

    public function getAssetTransmitter(): ?AssetTransmitter
    {
        if ($this->assetTransmitter === null) {
            // Reuse internal HTTP client
            $this->assetTransmitter = new InternalAssetTransmitter($this->getHttpClient());
        }

        return $this->assetTransmitter;
    }

    public function setAssetTransmitter(?AssetTransmitter $assetTransmitter = null): void
    {
        $this->assetTransmitter = $assetTransmitter;
    }

    public function fetchAsset(string $id): ?Response\Resource
    {
        /** @var Response\ResourceResponse|null $response */
        $response = $this->__call(__FUNCTION__, [['asset_id' => $id]]);

        return $response !== null ? $response->getResource() : null;
    }

    public function downloadAsset(string $id, ?string $imageId = null, ?int $expireAfter = null): ?string
    {
        $params = ['asset_id' => $id];

        if ($expireAfter !== null) {
            $params['expire_after'] = $expireAfter;
        }

        if ($imageId !== null) {
            $params['image_id'] = $imageId;
            $function = 'downloadImage';
        } else {
            $function = __FUNCTION__;
        }

        /** @var Response\ResourceResponse|null $response */
        $response = $this->__call($function, [$params]);

        return $response !== null ? $response->getResource()->get('url') : null;
    }

    public function downloadPreview(string $id, ?int $expireAfter = null): ?string
    {
        return $this->downloadAsset($id, 'web', $expireAfter);
    }

    public function createAsset(array $params): Response\Resource
    {
        /** @var Response\ResourceResponse $response */
        $response = $this->__call(__FUNCTION__, [$params]);

        return $response->getResource();
    }

    public function uploadAsset(AssetUpload $upload): Response\Resource
    {
        /** @todo Handle errors during the various upload steps (we might need to cleanup) */

        $transmitter = $this->getAssetTransmitter();

        if ($transmitter === null) {
            throw new Exception\RuntimeException('No asset transmitter set; cannot upload an asset');
        }

        $tentativeAssetData = ['name' => $upload->getName()];

        if ($upload->getMimeType() !== null) {
            $tentativeAssetData['mime_type'] = $upload->getMimeType();
        }

        $tentativeAsset = $this->createTentativeAsset($tentativeAssetData);

        $upload->setId($tentativeAsset->get('id'));
        $upload->setUploadUrl($tentativeAsset->get('upload_url'));
        $upload->setMimeType($tentativeAsset->get('mime_type'));
        $upload->setAcl($tentativeAsset->get('acl'));
        $upload->setEncryption($tentativeAsset->get('encryption'));

        $transmitter->upload($upload);

        $assetData = [
            'id' => $upload->getId(),
            'purpose' => $upload->getPurpose(),
            'name' => $upload->getName(),
            'url' => $upload->getUrl(),
            'size' => $upload->getSize(),
            'mime_type' => $upload->getMimeType(),
            'type' => $upload->getType(),
            'description' => $upload->getDescription(),
            'languages' => $upload->getLanguages(),
            'tags' => $upload->getTags(),
            'articles' => $upload->getArticles(),
            'archived' => $upload->isArchived(),
        ];

        $asset = $this->createAsset($assetData);

        return $asset;
    }

    public function deleteAsset(string $id): void
    {
        $this->__call(__FUNCTION__, [['asset_id' => $id]]);
    }

    public function createTentativeAsset(array $params): Response\Resource
    {
        /** @var Response\ResourceResponse $response */
        $response = $this->__call(__FUNCTION__, [$params]);

        return $response->getResource();
    }

    public function deleteTentativeAsset(string $id): void
    {
        $this->__call(__FUNCTION__, [['tentative_asset_id' => $id]]);
    }

    public function listAssetCollectionsByUrlToken(string $urlToken, array $params = []): Response\ListResponse
    {
        $filters = [
            'url_token' => [
                'property' => 'links.url_token',
                'value' => $urlToken,
                'operator' => '=',
                'type' => 'string'
            ],
        ];

        // We may need to replace already existing filters
        $this->addOrReplaceFilters($filters, $params);

        return $this->listAssetCollections($params);
    }
}
