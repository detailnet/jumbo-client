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
    /**
     * @param integer $year
     * @param integer $week
     * @param array $params
     * @return Response\ListResponse
     */
    public function listPromotionsByWeek($year, $week, array $params = array())
    {
        $weekFilters = array(
            'year' => array('property' => 'year', 'value' => $year, 'operator' => '=', 'type' => 'integer'),
            'week' => array('property' => 'week', 'value' => $week, 'operator' => '=', 'type' => 'integer'),
        );

        // We may need to replace already existing filters
        if (isset($params['filter']) && is_array($params['filter'])) {
            $filters = array();

            foreach ($params['filter'] as $filter) {
                if (isset($filter['property']) && isset($weekFilters[$filter['property']])) {
                    $filters[] = $weekFilters[$filter['property']];
                    unset($weekFilters[$filter['property']]);
                } else {
                    $filters[] = $filter;
                }
            }

            // Append remaining filters
            $filters += $weekFilters;
        } else {
            $filters = array_values($weekFilters);
        }

        $params['filter'] = $filters;

        return $this->listPromotions($params);
    }
}
