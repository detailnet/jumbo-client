<?php

use Denner\Client\Response;

return array(
    'name' => 'Denner Appraisal Service',
    'operations' => array(
        'listRatings' => array(
            'httpMethod' => 'GET',
            'uri' => 'ratings',
            'summary' => 'List articles rating',
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
                'f.count' => array(
                    '$ref' => 'FilterCountParam',
                ),
                'f.value' => array(
                    '$ref' => 'FilterValueParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'ratings',
        ),
        'fetchRating' => array(
            'httpMethod' => 'GET',
            'uri' => 'ratings/{article_id}',
            'summary' => 'Fetch an article rating',
            'parameters' => array(
                'article_id' => array(
                    'description' => 'The ID of the article (wine) rating to fetch',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
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
        'FilterCountParam' => array(
            'description' => 'Filter by count, e.g. "f.count=__gte_10" will return all article rating infos which have at least 10 valid appraisals.',
            'location' => 'query',
            'type' => 'string',
            'required' => false
        ),
        'FilterValueParam' => array(
            'description' => 'Filter by average value, e.g. "f.value=__gte_4" will return all article rating infos which value is at least 4.',
            'location' => 'query',
            'type' => 'string',
            'required' => false
        ),
        'SortParam' => array(
            'description' => 'Sorter, e.g. "sort=value__asc" will sort by rating value',
            'location' => 'query',
            'type' => 'string',
            'required' => false,
        ),
    ),
);
