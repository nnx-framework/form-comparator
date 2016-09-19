<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Nnx\FormComparator\Comparator\AbstractDiff;
use Nnx\FormComparator\Comparator\DiffBuilder;
use Zend\Form\ElementInterface;

/**
 * Class UpdateElement
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class UpdateElement extends AbstractDiff
{
    /**
     * Старое значение
     *
     * @var mixed
     */
    private $sourceValue;

    /**
     * Новое значение
     *
     * @var mixed
     */
    private $targetValue;

    /**
     * Элемент который сравнивают
     *
     * @var ElementInterface
     */
    private $sourceElement;

    /**
     * Элемент с которым сравнивают
     *
     * @var ElementInterface
     */
    private $targetElement;

    /**
     * UpdateElement constructor.
     *
     * @param DiffBuilder $diffBuilder
     */
    public function __construct(DiffBuilder $diffBuilder)
    {
        $this->sourceValue = $diffBuilder->getSourceValue();
        $this->targetValue = $diffBuilder->getTargetValue();
        $this->sourceElement = $diffBuilder->getSourceElement();
        $this->targetElement = $diffBuilder->getTargetElement();

        parent::__construct($diffBuilder);
    }

    /**
     * Элемент который сравнивают
     *
     * @return ElementInterface
     */
    public function getSourceElement()
    {
        return $this->sourceElement;
    }

    /**
     * Элемент с которым сравнивают
     *
     * @return ElementInterface
     */
    public function getTargetElement()
    {
        return $this->targetElement;
    }


    /**
     * @return mixed
     */
    public function getSourceValue()
    {
        return $this->sourceValue;
    }

    /**
     * @param mixed $sourceValue
     *
     * @return $this
     */
    public function setSourceValue($sourceValue)
    {
        $this->sourceValue = $sourceValue;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetValue()
    {
        return $this->targetValue;
    }

    /**
     * @param mixed $targetValue
     *
     * @return $this
     */
    public function setTargetValue($targetValue)
    {
        $this->targetValue = $targetValue;

        return $this;
    }
}
