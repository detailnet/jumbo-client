<?php

use Jumbo\Client\Response;

return array(
    'name' => 'Jumbo Assets Service',
    'operations' => array(
        'listAssets' => array(
            'httpMethod' => 'GET',
            'uri' => 'assets',
            'summary' => 'List assets',
            'parameters' => array(
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
                'query' => array(
                    'description' => 'Full text search query (currently searches only in asset name)',
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ),
                'filter' => array(
                    '$ref' => 'FilterParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseModel' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'assets',
        ),
        'fetchAsset' => array(
            'httpMethod' => 'GET',
            'uri' => 'assets/{asset_id}',
            'summary' => 'Fetch an asset',
            'parameters' => array(
                'asset_id' => array(
                    'description' => 'The ID of the asset to fetch',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'listAssetCollections' => array(
            'httpMethod' => 'GET',
            'uri' => 'asset-collections',
            'summary' => 'List asset collections',
            'parameters' => array(
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
                'filter' => array(
                    '$ref' => 'FilterParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'asset_collections',
        ),
        'listPurposes' => array(
            'httpMethod' => 'GET',
            'uri' => 'purposes',
            'summary' => 'List asset purposes',
            'parameters' => array(
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
                'filter' => array(
                    '$ref' => 'FilterParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'purposes',
        ),
    ),
    'models' => array(
        'PageParam' => array(
            'description' => 'The number of the page',
            'location' => 'query',
            'type' => 'integer',
            'required' => false,
        ),
        'PageSizeParam' => array(
            'description' => 'The number of items to list on a page',
            'location' => 'query',
            'type' => 'integer',
            'required' => false,
        ),
        'Filter' => array(
            'type' => 'object',
            'properties' => array(
                'property' => array(
                    'description' => 'The property to filter against',
                    'type' => 'string',
                    'required' => true,
                ),
                'value' => array(
                    'description' => 'The value to filter against',
                    'type' => array('array', 'string', 'integer', 'boolean', 'number', 'numeric', 'object'),
                    'required' => true,
                ),
                'operator' => array(
                    'description' => 'The operator the use for filtering',
                    'type' => 'string',
                    'required' => false,
                ),
                'type' => array(
                    'description' => 'The data type of the value',
                    'type' => 'string',
                    'required' => false,
                ),
            ),
        ),
        'FilterParam' => array(
            'description' => 'An array of filters',
            'location' => 'query',
            'type' => 'array',
            'required' => false,
            'items' => array(
                '$ref' => 'Filter',
            ),
        ),
        'Sort' => array(
            'type' => 'object',
            'properties' => array(
                'property' => array(
                    'description' => 'The property use for sorting',
                    'type' => 'string',
                    'required' => true,
                ),
                'direction' => array(
                    'description' => 'The sorting direction (either "asc" or "desc")',
                    'type' => 'string',
                    'required' => false,
                ),
            ),
        ),
        'SortParam' => array(
            'description' => 'An array of sorters',
            'location' => 'query',
            'type' => 'array',
            'required' => false,
            'items' => array(
                '$ref' => 'Sort',
            ),
        ),
    ),
);
