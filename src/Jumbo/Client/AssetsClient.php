<?php

namespace Jumbo\Client;

use Jumbo\Client\Response;

/**
 * Jumbo Assets Service client.
 *
 * @method Response\ListResponse listAssets(array $params = array())
 * @method Response\ResourceResponse fetchAsset(array $params = array())
 * @method Response\ListResponse listAssetCollections(array $params = array())
 * @method Response\ListResponse listPurposes(array $params = array())
 */
class AssetsClient extends JumboClient
{
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
