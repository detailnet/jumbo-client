<?php

use Denner\Client\Model\Promotion;

return array(
    'name' => 'Denner Articles',
    'operations' => array(
        'listAdvertisedArticles' => array(
            'httpMethod' => 'GET',
            'uri' => 'advertised-articles',
            'summary' => 'List advertised articles',
            'parameters' => array(
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
//                'query' => array(
//                    'description' => 'Full text search query (currently searches only in advertised article name)',
//                    'location' => 'query',
//                    'type' => 'string',
//                    'required' => false,
//                ),
                'filter' => array(
                    '$ref' => 'FilterParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => 'ListAdvertisedArticlesResponse',
        ),
        'fetchAdvertisedArticle' => array(
            'httpMethod' => 'GET',
            'uri' => 'advertised-articles/{advertised_article_id}',
            'summary' => 'Fetch an advertisedArticle',
            'parameters' => array(
                'advertised_article_id' => array(
                    'description' => 'The ID of the advertised article to fetch',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
            'responseClass' => 'AdvertisedArticle',
        ),
        'listPromotions' => array(
            'class' => 'Denner\\Client\\Command\\OperationCommand',
            'httpMethod' => 'GET',
            'uri' => 'promotions',
            'summary' => 'List promotions',
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
//            'responseClass' => 'ListPromotionsResponse',

            // Use of own model response class documented here:
            // http://guzzle3.readthedocs.org/webservice-client/guzzle-service-descriptions.html#responseclass
            // Problem is that the Guzzle\Service\Command\OperationCommand can't handle it, an own
            // command should be done.
            // Possible implementation example here:
            //   http://guzzle3.readthedocs.org/webservice-client/webservice-client.html
            'responseClass' => 'Promotion',
////            'responseClass' => Promotion::CLASS,
        ),
//        'fetchPromotion' => array(
//            'httpMethod' => 'GET',
//            'uri' => 'promotions/{promotion_id}',
//            'summary' => 'Fetch a promotion',
//            'parameters' => array(
//                'promotion_id' => array(
//                    'description' => 'The ID of the promotion to fetch',
//                    'location' => 'uri',
//                    'type' => 'string',
//                    'required' => true,
//                ),
//            ),
//            'responseClass' => 'Promotion',
//        ),
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
                    'type' => 'string',
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
        'PageSizeProperty' => array(
            'description' => 'The page size',
            'location' => 'json',
            'type' => 'integer',
        ),
        'PageCountProperty' => array(
            'description' => 'The total number of pages',
            'location' => 'json',
            'type' => 'integer',
        ),
        'TotalItemsProperty' => array(
            'description' => 'The total number of items',
            'location' => 'json',
            'type' => 'integer',
        ),
        'Week' => array(
            'description' => 'Week',
            'location' => 'json',
            'type' => 'object',
        ),
        'AdvertisedArticle' => array(
            'type' => 'object',
            // Sub-objects have to be defined
            'properties' => array(
                'week' => array(
                    '$ref' => 'Week',
                ),
            ),
            // Keep properties dynamic
            'additionalProperties' => array(
                'location' => 'json',
            ),
        ),
        'ListAdvertisedArticlesResponse' => array(
            'type' => 'object',
            'properties' => array(
                'advertised_articles' => array(
                    'description' => 'The resulting advertised articles',
                    'location' => 'json',
                    'type' => 'array',
                    'items' => array(
                        '$ref' => 'AdvertisedArticle',
                    ),
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeProperty',
                ),
                'page_count' => array(
                    '$ref' => 'PageCountProperty',
                ),
                'total_items' => array(
                    '$ref' => 'TotalItemsProperty',
                ),
            ),
        ),
        'PromotionType' => array(
            'type' => 'object',
            // Keep properties dynamic
            'additionalProperties' => array(
                'location' => 'json',
            ),
        ),
        'Promotion' => array(
            'type' => 'object',
            // Sub-objects have to be defined
            'properties' => array(
                'type' => array(
                    '$ref' => 'PromotionType',
                ),
                'week' => array(
                    '$ref' => 'Week',
                ),
            ),
            // Keep properties dynamic
            'additionalProperties' => array(
                'location' => 'json',
            ),
        ),
        'ListPromotionsResponse' => array(
            'type' => 'object',
            'properties' => array(
                'promotions' => array(
                    'description' => 'The resulting promotions',
                    'location' => 'json',
                    'type' => 'array',
                    'items' => array(
                        '$ref' => 'Promotion',
                    ),
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeProperty',
                ),
                'page_count' => array(
                    '$ref' => 'PageCountProperty',
                ),
                'total_items' => array(
                    '$ref' => 'TotalItemsProperty',
                ),
            ),
        ),
    ),
);
