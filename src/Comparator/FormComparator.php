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
     */
    public function compare(Context $context)
    {
        $this->context = $context;

        foreach ($this->context->getComparableForm() as $comparableForm) {
            $diff = $this->formDiffBuilder->buildDiff($comparableForm->getSourceForm(), $comparableForm->getTargetForm());
        }



        
        
        
        
        
        return;
    }
}
