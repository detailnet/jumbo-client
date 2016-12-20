<?php

namespace Denner\Client;

use Denner\Client\Response;

/**
 * Denner Translations Service client.
 *
 * @method Response\ListResponse listJobs(array $params = array())
 * @method Response\ResourceResponse updateJob(array $params = array())
 */
class TranslationsClient extends DennerClient
{
    /**
     * @param string $articleId
     * @param array $params
     * @return Response\ListResponse
     */
    public function listJobsByArticle($articleId, array $params = array())
    {
        $filters = array(
            'f.item.type' => 'article',
            'f.item.id' => $articleId,
        );

        // We may need to replace an already existing filter
        $this->addOrReplaceFilters($filters, $params);

        return $this->listJobs($params);
    }

    /**
     * @param array $params
     * @return Response\ListResponse
     */
    public function listTranslatedJobs(array $params = array())
    {
        $filters = array(
            'f.status' => 'translated',
        );

        // We may need to replace an already existing filter
        $this->addOrReplaceFilters($filters, $params);

        return $this->listJobs($params);
    }
}
