<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;

use Webmozart\Assert\Assert;
use Zend\ServiceManager\AbstractPluginManager;
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
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appServiceLocator = $serviceLocator instanceof AbstractPluginManager ? $serviceLocator->getServiceLocator() : $serviceLocator;

        /** @var  FormDiffService $formDiffBuilder */
        $formDiffBuilder = $appServiceLocator->get(FormDiffService::class);
        Assert::isInstanceOf($formDiffBuilder, FormDiffService::class);

        return new FormComparator($formDiffBuilder);
    }

}
