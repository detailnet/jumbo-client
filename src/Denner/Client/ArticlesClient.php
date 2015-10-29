<?php

namespace Denner\Client;

use Denner\Client\Response;

/**
 * Denner Articles Service client.
 *
 * @method Response\ListResponse listAdvertisedArticles(array $params = array())
 * @method Response\ResourceResponse fetchAdvertisedArticle(array $params = array())
 * @method Response\ListResponse listPromotions(array $params = array())
 */
class ArticlesClient extends DennerClient
{
}
