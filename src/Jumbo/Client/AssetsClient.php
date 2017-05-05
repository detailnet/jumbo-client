<?php

namespace Jumbo\Client;

use Jumbo\Client\Response;

/**
 * Jumbo Assets Service client.
 *
 * @method Response\ListResponse listAssets(array $params = array())
 * @method Response\ListResponse listAssetCollections(array $params = array())
 * @method Response\ListResponse listPurposes(array $params = array())
 */
class AssetsClient extends JumboClient
{
    /**
     * @var AssetTransmitter|null
     */
    protected $assetTransmitter;

    /**
     * @return AssetTransmitter|null
     */
    public function getAssetTransmitter()
    {
        if ($this->assetTransmitter === null) {
            // Reuse internal HTTP client
            $this->assetTransmitter = new InternalAssetTransmitter($this->getHttpClient());
        }

        return $this->assetTransmitter;
    }

    /**
     * @param AssetTransmitter|null $assetTransmitter
     */
    public function setAssetTransmitter(AssetTransmitter $assetTransmitter = null)
    {
        $this->assetTransmitter = $assetTransmitter;
    }

    /**
     * @param string $id
     * @return Response\Resource|null
     */
    public function fetchAsset($id)
    {
        /** @var Response\ResourceResponse|null $response */
        $response = $this->__call(__FUNCTION__, array(array('asset_id' => $id)));

        return $response ? $response->getResource() : null;
    }

    /**
     * @param string $id
     * @param integer|null $expireAfter
     * @return string|null
     */
    public function downloadAsset($id, $expireAfter = null)
    {
        $params = array('asset_id' => $id);

        if ($expireAfter !== null) {
            $params['expire_after'] = $expireAfter;
        }

        /** @var Response\ResourceResponse|null $response */
        $response = $this->__call(__FUNCTION__, array($params));

        return $response ? $response->getResource()->get('url') : null;
    }

    /**
     * @param array $params
     * @return Response\Resource
     */
    public function createAsset(array $params)
    {
        /** @var Response\ResourceResponse $response */
        $response = $this->__call(__FUNCTION__, array($params));

        return $response->getResource();
    }

    /**
     * @param AssetUpload $upload
     * @return Response\Resource
     * @todo Handle errors during the various upload steps (we might need to cleanup)
     */
    public function uploadAsset(AssetUpload $upload)
    {
        $transmitter = $this->getAssetTransmitter();

        if ($transmitter === null) {
            throw new Exception\RuntimeException('No asset transmitter set; cannot upload an asset');
        }

        $tentativeAssetData = array('name' => $upload->getName());

        if ($upload->getMimetype() !== null) {
            $tentativeAssetData['mime_type'] = $upload->getMimetype();
        }

        $tentativeAsset = $this->createTentativeAsset($tentativeAssetData);

        $upload->setId($tentativeAsset->get('id'));
        $upload->setUploadUrl($tentativeAsset->get('upload_url'));
        $upload->setMimeType($tentativeAsset->get('mime_type'));
        $upload->setAcl($tentativeAsset->get('acl'));
        $upload->setEncryption($tentativeAsset->get('encryption'));

        $transmitter->upload($upload);

        $assetData = array(
            'id' => $upload->getId(),
            'purpose' => $upload->getPurpose(),
            'name' => $upload->getName(),
            'url' => $upload->getUrl(),
            'size' => $upload->getSize(),
            'mime_type' => $upload->getMimetype(),
            'type' => $upload->getType(),
            'description' => $upload->getDescription(),
            'languages' => $upload->getLanguages(),
            'tags' => $upload->getTags(),
            'articles' => $upload->getArticles(),
            'archived' => $upload->isArchived(),
        );

        $asset = $this->createAsset($assetData);

        return $asset;
    }

    /**
     * @param string $id
     * @return void
     */
    public function deleteAsset($id)
    {
        $this->__call(__FUNCTION__, array(array('asset_id' => $id)));
    }

    /**
     * @param array $params
     * @return Response\Resource
     */
    public function createTentativeAsset(array $params)
    {
        /** @var Response\ResourceResponse $response */
        $response = $this->__call(__FUNCTION__, array($params));

        return $response->getResource();
    }

    /**
     * @param string $id
     * @return void
     */
    public function deleteTentativeAsset($id)
    {
        $this->__call(__FUNCTION__, array(array('tentative_asset_id' => $id)));
    }

    /**
     * @param string $urlToken
     * @param array $params
     * @return Response\ListResponse
     */
    public function listAssetCollectionsByUrlToken($urlToken, array $params = array())
    {
        $filters = array(
            'url_token' => array('property' => 'links.url_token', 'value' => $urlToken, 'operator' => '=', 'type' => 'string'),
        );

        // We may need to replace already existing filters
        $this->addOrReplaceFilters($filters, $params);

        return $this->listAssetCollections($params);
    }
}
