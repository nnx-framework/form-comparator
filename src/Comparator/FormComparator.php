<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;

use Nnx\FormComparator\Context\Context;

/**
 * Class FormComparator
 *
 * @package Nnx\FormComparator\Comparator
 */
class FormComparator
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var FormDiffService
     */
    private $formDiffBuilder;

    /**
     * FormComparator constructor.
     *
     * @param FormDiffService $formDiffBuilder
     */
    public function __construct(FormDiffService $formDiffBuilder)
    {
        $this->formDiffBuilder = $formDiffBuilder;
    }


    /**
     * @param Context $context
     *
     * @return AbstractDiff[]
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     * @throws \Nnx\FormComparator\Comparator\Exception\RuntimeException
     */
    public function compare(Context $context)
    {
        $this->context = $context;

        $diff = [];
        foreach ($this->context->getComparableForm() as $comparableForm) {
            $formDiff = $this->formDiffBuilder->buildDiff($comparableForm->getSourceForm(), $comparableForm->getTargetForm());
            $diff = array_merge($diff, $formDiff);
        }

        return $diff;
    }
}
