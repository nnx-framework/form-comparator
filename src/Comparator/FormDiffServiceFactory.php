<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FormDiffServiceFactory
 *
 * @package Nnx\FormComparator\Comparator
 */
class FormDiffServiceFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FormDiffService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new FormDiffService();
    }

}
