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
 * Class DeleteElement
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class DeleteElement extends AbstractDiff
{
    /**
     * Удаленный элемент
     *
     * @var ElementInterface
     */
    private $deletedElement;

    /**
     * Возвращает удаленный элемент (есть в форме которую сравнивают, но отсутствует в форме с которой сравнивают)
     *
     * @return ElementInterface
     */
    public function getDeletedElement()
    {
        return $this->deletedElement;
    }

    /**
     * DeleteElement constructor.
     *
     * @param DiffBuilder $diffBuilder
     */
    public function __construct(DiffBuilder $diffBuilder)
    {
        $this->deletedElement = $diffBuilder->getSourceElement();

        parent::__construct($diffBuilder);
    }
}
