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
        'downloadAsset' => array(
            'httpMethod' => 'POST',
            'uri' => 'assets/{asset_id}/downloads',
            'summary' => 'Download an asset (get the download URL)',
            'parameters' => array(
                'asset_id' => array(
                    'description' => 'The ID of the asset to download',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'expire_after' => array(
                    'description' => 'The number of seconds after which the download URL expires',
                    'location' => 'json',
                    'type' => 'integer',
                    'required' => false,
                ),
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'createAsset' => array(
            'httpMethod' => 'POST',
            'uri' => 'assets',
            'summary' => 'Create an asset',
            'parameters' => array(
                'id' => array(
                    'description' => 'The ID of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'purpose' => array(
                    'description' => 'The purpose of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                    'enum' => array(
                        'original',
                        'web',
                    ),
                ),
                'name' => array(
                    'description' => 'The name of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                    'minLength' => 1,
                ),
                'url' => array(
                    'description' => 'The URL of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'size' => array(
                    'description' => 'The size of the asset',
                    'location' => 'json',
                    'type' => 'integer',
                    'required' => true,
                    'minimum' => 1,
                ),
                'mime_type' => array(
                    'description' => 'The mime-type of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'type' => array(
                    'description' => 'The type of the asset (the ID)',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'description' => array(
                    'description' => 'The description for the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => false,
                ),
                'languages' => array(
                    'description' => 'The languages for the asset (the IDs)',
                    'location' => 'json',
                    'type' => 'array',
                    'required' => false,
                ),
                'tags' => array(
                    'description' => 'The tags for the asset (the IDs)',
                    'location' => 'json',
                    'type' => 'array',
                    'required' => false,
                ),
                'articles' => array(
                    'description' => 'The referenced articles for the asset',
                    'location' => 'json',
                    'type' => 'array',
                    'required' => false,
                    'items' => array(
                        'type' => 'object',
                        'properties' => array(
                            'code' => array(
                                'description' => 'The referenced articles for the asset',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                ),
                'archived' => array(
                    'description' => 'Whether or not to create the asset directly as archived',
                    'location' => 'json',
                    'type' => 'boolean',
                    'required' => false,
                ),
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'deleteAsset' => array(
            'httpMethod' => 'DELETE',
            'uri' => 'assets/{asset_id}',
            'summary' => 'Delete an asset',
            'parameters' => array(
                'asset_id' => array(
                    'description' => 'The ID of the asset to delete',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'createTentativeAsset' => array(
            'httpMethod' => 'POST',
            'uri' => 'assets/new',
            'summary' => 'Create a tentative asset',
            'parameters' => array(
                'name' => array(
                    'description' => 'The name of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ),
                'mime_type' => array(
                    'description' => 'The mime-type of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => false,
                ),
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'deleteTentativeAsset' => array(
            'httpMethod' => 'DELETE',
            'uri' => 'assets/new/{tentative_asset_id}',
            'summary' => 'Delete a tentative asset',
            'parameters' => array(
                'tentative_asset_id' => array(
                    'description' => 'The ID of the tentative asset to delete',
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
