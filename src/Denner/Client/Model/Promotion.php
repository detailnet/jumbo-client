<?php

/** This is still not used, never tested */

namespace Denner\Client\Model;

use Guzzle\Service\Command\ResponseClassInterface;
use Guzzle\Service\Command\OperationCommand;

use Rhumsaa\Uuid\Uuid;

use Denner\Common\Date\Week;
use Denner\Common\Promotion as PromotionCommon;

class Promotion extends PromotionCommon\Promotion implements
    ResponseClassInterface
{
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();
        $xml = $response->xml();

        //var_dump($xml); die();

        return new self(
            Uuid::fromString($xml->id),
            $xml->code,
            new PromotionCommon\PromotionType(
                Uuid::fromString($xml->type->id),
                $xml->type->code,
                $xml->type->name
            ),
            \DateTime::createFromFormat('!...', $xml->startsOn), /** @todo Set correct format, '!' needed to create without "time" */
            new Week(
                $xml->week->year,
                $xml->week->number
            )
        );
    }
}
