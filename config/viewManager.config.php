<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator;



return [
    'view_manager' => [
        'template_map'        => array_merge(
            [
                'form-comparator/default-diff' => __DIR__ . '/../view/form-comparator/default-diff.phtml',
            ],
            file_exists(__DIR__ . '/../template_map.php') ? include __DIR__ . '/../template_map.php' : []
        )
    ]
];
