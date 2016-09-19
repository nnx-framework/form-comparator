<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Nnx\FormComparator\Comparator\AbstractDiff;
use Zend\Form\Element\Collection;

/**
 * Class UpdateCollection
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class UpdateCollection extends AbstractDiff
{
    /**
     * Коллекция которую сравнивают
     *
     * @var Collection
     */
    private $sourceCollection;

    /**
     * Коллекция с которой сравнивают
     *
     * @var Collection
     */
    private $targetCollection;

    /**
     * Расхождение между элементами коллекций
     *
     * @var AbstractDiff[]
     */
    private $diff = [];

//    /**
//     * UpdateElement constructor.
//     *
//     * @param DiffBuilder $diffBuilder
//     */
//    public function __construct(DiffBuilder $diffBuilder)
//    {
//        $this->sourceValue = $diffBuilder->getSourceValue();
//        $this->targetValue = $diffBuilder->getTargetValue();
//        $this->sourceCollection = $diffBuilder->getSourceElement();
//        $this->targetCollection = $diffBuilder->getTargetElement();
//
//        parent::__construct($diffBuilder);
//    }

    /**
     * Коллекция которую сравнивают
     *
     * @return Collection
     */
    public function getSourceCollection()
    {
        return $this->sourceCollection;
    }

    /**
     * Коллекция с которой сравнивают
     *
     * @return Collection
     */
    public function getTargetCollection()
    {
        return $this->targetCollection;
    }

    /**
     * Расхождение между элементами коллекций
     *
     * @return \Nnx\FormComparator\Comparator\AbstractDiff[]
     */
    public function getDiff()
    {
        return $this->diff;
    }


}
