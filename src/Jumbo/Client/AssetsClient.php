<?php

namespace Jumbo\Client;

use GuzzleHttp\Exception\ClientException;
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
