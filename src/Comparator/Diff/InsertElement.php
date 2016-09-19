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
 * Class InsertElement
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class InsertElement extends AbstractDiff
{
    /**
     * Возвращает добавленный элемент
     *
     * @var ElementInterface
     */
    private $insertedElement;

    /**
     * Возвращает добавленный элемент (нет в форме которую сравнивают, но есть в форме с которой сравнивают)
     *
     * @return ElementInterface
     */
    public function getInsertedElement()
    {
        return $this->insertedElement;
    }

    /**
     * InsertElement constructor.
     *
     * @param DiffBuilder $diffBuilder
     */
    public function __construct(DiffBuilder $diffBuilder)
    {
        $this->insertedElement = $diffBuilder->getTargetElement();

        parent::__construct($diffBuilder);
    }
}
