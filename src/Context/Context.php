<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Context;

/**
 * Class Context
 *
 * @package Nnx\FormComparator\Context
 */
class Context
{
    /**
     * Массив объектов, каждый из которых содержит информацию о том какие формы необходимо сравнивать
     *
     * @var ComparableForm[]
     */
    private $comparableForm = [];

    /**
     * Context constructor.
     *
     * @param ContextBuilder $builder
     */
    public function __construct(ContextBuilder $builder)
    {
        $this->comparableForm = $builder->getComparableForm();
    }
}
