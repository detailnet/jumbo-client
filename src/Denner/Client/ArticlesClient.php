<?php

namespace Denner\Client;

use Denner\Client\Subscriber;

/**
 * Denner API client.
 *
 * @method array listAdvertisedArticles(array $params = array())
 * @method array fetchAdvertisedArticle(array $params = array())
 * // @method array fetchPromotion(array $params = array())
 */
class ArticlesClient extends DennerClient
{
    /**
     * @return string
     */
    protected static function getDefaultServiceUrl()
    {
        return 'https://denner-articles.detailnet.ch/api/';
    }
}
