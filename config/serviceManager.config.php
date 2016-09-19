<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator;

use Nnx\FormComparator\Comparator\FormComparator;
use Nnx\FormComparator\Comparator\FormComparatorFactory;
use Nnx\FormComparator\Comparator\FormDiffService;
use Nnx\FormComparator\Comparator\FormDiffServiceFactory;
use Nnx\FormComparator\Context\ContextBuilder;
use Nnx\FormComparator\Context\ContextBuilderFactory;

return [
    'service_manager' => [
        'invokables'         => [

        ],
        'factories'          => [
            ContextBuilder::class  => ContextBuilderFactory::class,
            FormComparator::class  => FormComparatorFactory::class,
            FormDiffService::class => FormDiffServiceFactory::class
        ],
        'abstract_factories' => [

        ],
        'shared' => [
            ContextBuilder::class => false
        ]
    ],
];


