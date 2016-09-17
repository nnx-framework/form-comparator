<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Context;

use Webmozart\Assert\Assert;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\FormElementManager;

/**
 * Class ContextBuilderFactory
 *
 * @package Nnx\FormComparator\Context
 */
class ContextBuilderFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ContextBuilder
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appServiceLocator = $serviceLocator instanceof AbstractPluginManager ? $serviceLocator->getServiceLocator() : $serviceLocator;

        /** @var FormElementManager $formElementManager */
        $formElementManager = $appServiceLocator->get('FormElementManager');
        Assert::isInstanceOf($formElementManager, FormElementManager::class);

        return new ContextBuilder($formElementManager);
    }

}
