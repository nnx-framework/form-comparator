<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Nnx\FormComparator\Comparator\AbstractDiff;
use Nnx\FormComparator\Comparator\DiffBuilder;
use Zend\Form\Element\Collection;

/**
 * Class DeleteCollection
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class DeleteCollection extends AbstractDiff
{
    /**
     * Удаленная коллекция
     *
     * @var Collection
     */
    private $deletedCollection;

    /**
     * Элементы удаленной коллекции
     *
     * @var DeleteElement[]
     */
    private $deletedElement = [];

    /**
     * Возвращает элементы удаленной коллекции
     *
     * @return DeleteElement[]
     */
    public function getDeletedElement()
    {
        return $this->deletedElement;
    }
    /**
     * Возвращает удаленную коллекцию
     *
     * @return Collection
     */
    public function getDeletedCollection()
    {
        return $this->deletedCollection;
    }

    /**
     * InsertElement constructor.
     *
     * @param DiffBuilder $diffBuilder
     */
    public function __construct(DiffBuilder $diffBuilder)
    {
        $this->deletedCollection = $diffBuilder->getTargetElement();

        parent::__construct($diffBuilder);
    }
}
