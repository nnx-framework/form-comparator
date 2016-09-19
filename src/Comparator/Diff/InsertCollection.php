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
 * Class InsertCollection
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class InsertCollection extends AbstractDiff
{
    /**
     * Добавленная коллекция
     *
     * @var Collection
     */
    private $insertedCollection;

    /**
     * Элементы добавленной коллекции
     *
     * @var InsertElement[]
     */
    private $insertedElement = [];

    /**
     * Возвращает элементы добавленной коллекции
     *
     * @return InsertElement[]
     */
    public function getInsertedElement()
    {
        return $this->insertedElement;
    }
    /**
     * Возвращает добавленную коллекцию (нет в форме которую сравнивают, но есть в форме с которой сравнивают)
     *
     * @return Collection
     */
    public function getInsertedCollection()
    {
        return $this->insertedCollection;
    }

    /**
     * InsertElement constructor.
     *
     * @param DiffBuilder $diffBuilder
     */
    public function __construct(DiffBuilder $diffBuilder)
    {
        $this->insertedCollection = $diffBuilder->getTargetElement();

        parent::__construct($diffBuilder);
    }
}
