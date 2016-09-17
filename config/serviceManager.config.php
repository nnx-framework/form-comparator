<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator;

use Nnx\FormComparator\Comparator\FormComparator;
use Nnx\FormComparator\Comparator\FormComparatorFactory;
use Nnx\FormComparator\Context\ContextBuilder;
use Nnx\FormComparator\Context\ContextBuilderFactory;

return [
    'service_manager' => [
        'invokables'         => [

        ],
        'factories'          => [
            ContextBuilder::class => ContextBuilderFactory::class,
            FormComparator::class => FormComparatorFactory::class
        ],
        'abstract_factories' => [

        ]
    ],
];


