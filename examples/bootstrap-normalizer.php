<?php

$serializationBuilder = new \JMS\Serializer\SerializerBuilder();

$serializationBuilder->configureHandlers(function($handlerRegistry) {
    $handlerRegistry->registerSubscribingHandler(new Detail\Normalization\JMSSerializer\Handler\UuidHandler());
    $handlerRegistry->registerSubscribingHandler(new Detail\Normalization\JMSSerializer\Handler\DateHandler());
    $handlerRegistry->registerSubscribingHandler(new Detail\Normalization\JMSSerializer\Handler\ArrayCollectionHandler());
});

$serializationBuilder->addMetadataDir(
    __DIR__ . '/../resources/serializer/Denner.Common.Promotion',
    'Denner\Common\Promotion'
);

$serializationBuilder->addMetadataDir(
    __DIR__ . '/../resources/serializer/Denner.Common.Date',
    'Denner\Common\Date'
);

$cacheNamingStrategy = new \JMS\Serializer\Naming\CacheNamingStrategy(
    new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(
        new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy()
    )
);
$serializationBuilder->setSerializationVisitor(
    'php', new \Detail\Normalization\JMSSerializer\PhpSerializationVisitor($cacheNamingStrategy)
);
$serializationBuilder->setDeserializationVisitor(
    'php', new \Detail\Normalization\JMSSerializer\PhpDeserializationVisitor($cacheNamingStrategy)
);

$jmsSerializer = $serializationBuilder->build();
$normalizer = new \Detail\Normalization\Normalizer\JMSSerializerBasedNormalizer($jmsSerializer);

return $normalizer;
