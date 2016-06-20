<?php

namespace Denner\Client;

use Denner\Client\Response;

/**
 * Denner Shop API client.
 *
 * @method Response\ResourceResponse createSweepstakeParticipant(array $params = array())
 * @method Response\ResourceResponse createWineAppraisal(array $params = array())
 * @method Response\ListResponse listWineAppraisals(array $params = array())
 * @method Response\ListResponse listWines(array $params = array())
 */
class ShopClient extends DennerClient
{
}
