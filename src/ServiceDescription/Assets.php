<?php

use Jumbo\Client\Response;

return [
    'name' => 'Jumbo Assets Service',
    'operations' => [
        'listAssets' => [
            'httpMethod' => 'GET',
            'uri' => 'assets',
            'summary' => 'List assets',
            'parameters' => [
                'page' => [
                    '$ref' => 'PageParam',
                ],
                'page_size' => [
                    '$ref' => 'PageSizeParam',
                ],
                'query' => [
                    'description' => 'Full text search query (currently searches only in asset name)',
                    'location' => 'query',
                    'type' => 'string',
                    'required' => false,
                ],
                'filter' => [
                    '$ref' => 'FilterParam',
                ],
                'sort' => [
                    '$ref' => 'SortParam',
                ],
            ],
            'responseModel' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'assets',
        ],
        'fetchAsset' => [
            'httpMethod' => 'GET',
            'uri' => 'assets/{asset_id}',
            'summary' => 'Fetch an asset',
            'parameters' => [
                'asset_id' => [
                    'description' => 'The ID of the asset to fetch',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'downloadAsset' => [
            'httpMethod' => 'POST',
            'uri' => 'assets/{asset_id}/downloads',
            'summary' => 'Download an asset (get the download URL)',
            'parameters' => [
                'asset_id' => [
                    'description' => 'The ID of the asset to download',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ],
                'expire_after' => [
                    'description' => 'The number of seconds after which the download URL expires',
                    'location' => 'json',
                    'type' => 'integer',
                    'required' => false,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'downloadPreview' => [
            'httpMethod' => 'POST',
            'uri' => 'assets/{asset_id}/preview-downloads',
            'summary' => 'Download a preview (get the download URL)',
            'parameters' => [
                'asset_id' => [
                    'description' => 'The ID of the asset to download the preview for',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ],
                'expire_after' => [
                    'description' => 'The number of seconds after which the download URL expires',
                    'location' => 'json',
                    'type' => 'integer',
                    'required' => false,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'createAsset' => [
            'httpMethod' => 'POST',
            'uri' => 'assets',
            'summary' => 'Create an asset',
            'parameters' => [
                'id' => [
                    'description' => 'The ID of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ],
                'purpose' => [
                    'description' => 'The purpose of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                    'enum' => [
                        'original',
                        'web',
                    ],
                ],
                'name' => [
                    'description' => 'The name of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                    'minLength' => 1,
                ],
                'url' => [
                    'description' => 'The URL of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ],
                'size' => [
                    'description' => 'The size of the asset',
                    'location' => 'json',
                    'type' => 'integer',
                    'required' => true,
                    'minimum' => 1,
                ],
                'mime_type' => [
                    'description' => 'The mime-type of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ],
                'type' => [
                    'description' => 'The type of the asset (the ID)',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ],
                'description' => [
                    'description' => 'The description for the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => false,
                ],
                'languages' => [
                    'description' => 'The languages for the asset (the IDs)',
                    'location' => 'json',
                    'type' => 'array',
                    'required' => false,
                ],
                'tags' => [
                    'description' => 'The tags for the asset (the IDs)',
                    'location' => 'json',
                    'type' => 'array',
                    'required' => false,
                ],
                'articles' => [
                    'description' => 'The referenced articles for the asset',
                    'location' => 'json',
                    'type' => 'array',
                    'required' => false,
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'code' => [
                                'description' => 'The referenced articles for the asset',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                ],
                'archived' => [
                    'description' => 'Whether or not to create the asset directly as archived',
                    'location' => 'json',
                    'type' => 'boolean',
                    'required' => false,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'deleteAsset' => [
            'httpMethod' => 'DELETE',
            'uri' => 'assets/{asset_id}',
            'summary' => 'Delete an asset',
            'parameters' => [
                'asset_id' => [
                    'description' => 'The ID of the asset to delete',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'createTentativeAsset' => [
            'httpMethod' => 'POST',
            'uri' => 'assets/new',
            'summary' => 'Create a tentative asset',
            'parameters' => [
                'name' => [
                    'description' => 'The name of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => true,
                ],
                'mime_type' => [
                    'description' => 'The mime-type of the asset',
                    'location' => 'json',
                    'type' => 'string',
                    'required' => false,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'deleteTentativeAsset' => [
            'httpMethod' => 'DELETE',
            'uri' => 'assets/new/{tentative_asset_id}',
            'summary' => 'Delete a tentative asset',
            'parameters' => [
                'tentative_asset_id' => [
                    'description' => 'The ID of the tentative asset to delete',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ],
            ],
            'responseClass' => Response\ResourceResponse::CLASS,
        ],
        'listAssetCollections' => [
            'httpMethod' => 'GET',
            'uri' => 'asset-collections',
            'summary' => 'List asset collections',
            'parameters' => [
                'page' => [
                    '$ref' => 'PageParam',
                ],
                'page_size' => [
                    '$ref' => 'PageSizeParam',
                ],
                'filter' => [
                    '$ref' => 'FilterParam',
                ],
                'sort' => [
                    '$ref' => 'SortParam',
                ],
            ],
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'asset_collections',
        ],
        'listPurposes' => [
            'httpMethod' => 'GET',
            'uri' => 'purposes',
            'summary' => 'List asset purposes',
            'parameters' => [
                'page' => [
                    '$ref' => 'PageParam',
                ],
                'page_size' => [
                    '$ref' => 'PageSizeParam',
                ],
                'filter' => [
                    '$ref' => 'FilterParam',
                ],
                'sort' => [
                    '$ref' => 'SortParam',
                ],
            ],
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'purposes',
        ],
    ],
    'models' => [
        'PageParam' => [
            'description' => 'The number of the page',
            'location' => 'query',
            'type' => 'integer',
            'required' => false,
        ],
        'PageSizeParam' => [
            'description' => 'The number of items to list on a page',
            'location' => 'query',
            'type' => 'integer',
            'required' => false,
        ],
        'Filter' => [
            'type' => 'object',
            'properties' => [
                'property' => [
                    'description' => 'The property to filter against',
                    'type' => 'string',
                    'required' => true,
                ],
                'value' => [
                    'description' => 'The value to filter against',
                    'type' => ['array', 'string', 'integer', 'boolean', 'number', 'numeric', 'object'],
                    'required' => true,
                ],
                'operator' => [
                    'description' => 'The operator the use for filtering',
                    'type' => 'string',
                    'required' => false,
                ],
                'type' => [
                    'description' => 'The data type of the value',
                    'type' => 'string',
                    'required' => false,
                ],
            ],
        ],
        'FilterParam' => [
            'description' => 'An array of filters',
            'location' => 'query',
            'type' => 'array',
            'required' => false,
            'items' => [
                '$ref' => 'Filter',
            ],
        ],
        'Sort' => [
            'type' => 'object',
            'properties' => [
                'property' => [
                    'description' => 'The property use for sorting',
                    'type' => 'string',
                    'required' => true,
                ],
                'direction' => [
                    'description' => 'The sorting direction (either "asc" or "desc")',
                    'type' => 'string',
                    'required' => false,
                ],
            ],
        ],
        'SortParam' => [
            'description' => 'An array of sorters',
            'location' => 'query',
            'type' => 'array',
            'required' => false,
            'items' => [
                '$ref' => 'Sort',
            ],
        ],
    ],
];
