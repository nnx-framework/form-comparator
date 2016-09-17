<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FormComparatorFactory
 *
 * @package Nnx\FormComparator\Comparator
 */
class FormComparatorFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FormComparator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FormComparator();
    }

}
