<?php

use Denner\Client\Response;

return array(
    'name' => 'Denner Translations Service',
    'operations' => array(
        'listJobs' => array(
            'httpMethod' => 'GET',
            'uri' => 'jobs',
            'summary' => 'List translation jobs',
            'parameters' => array(
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
                'f.item.type' => array(
                    '$ref' => 'FilterItemTypeParam',
                ),
                'f.item.id' => array(
                    '$ref' => 'FilterItemIdParam',
                ),
                'f.source_language' => array(
                    '$ref' => 'FilterSourceLanguageParam',
                ),
                'f.status' => array(
                    '$ref' => 'FilterStatusParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'translations',
        ),
        'updateJob' => array(
            'httpMethod' => 'PATCH',
            'uri' => 'jobs/{job_id}',
            'summary' => 'Update a translation job',
            'parameters' => array(
                'job_id' => array(
                    'description' => 'The ID of the translation job to update',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
            ),
            'additionalParameters' => array(
                'location' => 'json',
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
        'FilterItemTypeParam' => array(
            'description' =>
                'Filter by item type, e.g. "f.item.type=article" will return all translations jobs for article texts.',
            'location' => 'query',
            'type' => 'string',
            'required' => false
        ),
        'FilterItemIdParam' => array(
            'description' =>
                'Filter by item id value (to be used in combination with f.item.type), e.g. "f.item.type=article&f.item.id=__in_051051||051052" will return all article translations jobs for articles "051051" and "051052" texts',
            'location' => 'query',
            'type' => 'string',
            'required' => false
        ),
        'FilterSourceLanguageParam' => array(
            'description' =>
                'Filter by source_language, e.g. "f.source_language=de" will return all translations jobs whose source language is german',
            'location' => 'query',
            'type' => 'string',
            'required' => false
        ),
        'FilterStatusParam' => array(
            'description' =>
                'Filter by status, e.g. "f.status=__in_open||translated" will return all translations jobs whose status is "open" or "translated"',
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
