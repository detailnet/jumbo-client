<?php

use Denner\Client\Response;

return array(
    'name' => 'Denner Shop API',
    'operations' => array(
        'createSweepstakeParticipant' => array(
            'httpMethod' => 'POST',
            'uri' => 'sweepstake-participants',
            'summary' => 'Create a sweepstake participant',
            'parameters' => array(
                /** @todo Define actions properly and remove "additionalParameters" as catch-all... */
            ),
            'additionalParameters' => array(
                'location' => 'json',
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'createWineAppraisal' => array(
            'httpMethod' => 'POST',
            'uri' => 'wines/{wine_id}/appraisals',
            'summary' => 'Create a wine appraisal',
            'parameters' => array(
                'wine_id' => array(
                    'description' => 'The ID of the wine for which to create the new appraisal',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                /** @todo Define actions properly and remove "additionalParameters" as catch-all... */
            ),
            'additionalParameters' => array(
                'location' => 'json',
            ),
            'responseClass' => Response\ResourceResponse::CLASS,
        ),
        'listWineAppraisals' => array(
            'httpMethod' => 'GET',
            'uri' => 'wines/{wine_id}/appraisals',
            'summary' => 'List a wine\'s appraisals',
            'parameters' => array(
                'wine_id' => array(
                    'description' => 'The ID of the wine for which to create the new appraisal',
                    'location' => 'uri',
                    'type' => 'string',
                    'required' => true,
                ),
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'appraisals',
        ),
        'listWines' => array(
            'httpMethod' => 'GET',
            'uri' => 'wines',
            'summary' => 'List wines',
            'parameters' => array(
                'page' => array(
                    '$ref' => 'PageParam',
                ),
                'page_size' => array(
                    '$ref' => 'PageSizeParam',
                ),
                'sort' => array(
                    '$ref' => 'SortParam',
                ),
            ),
            'responseClass' => Response\ListResponse::CLASS,
            'responseDataRoot' => 'articles',
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
        'SortParam' => array(
            'description' => 'The sort field and direction',
            'location' => 'query',
            'type' => 'string',
            'required' => false,
        ),
    ),
);
