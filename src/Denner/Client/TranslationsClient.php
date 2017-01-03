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
        $params['f.item.type'] = '__streq_article';
        $params['f.item.id'] = '__streq_' . $articleId;

        return $this->listJobs($params);
    }

    /**
     * @param array $params
     * @return Response\ListResponse
     */
    public function listTranslatedJobs(array $params = array())
    {
        $params['f.status'] = '__streq_translated';

        return $this->listJobs($params);
    }
}
