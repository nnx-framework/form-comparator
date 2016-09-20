<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;


use Nnx\FormComparator\Comparator\DiffElementBuilder;
use Zend\Form\Element\Collection;

/**
 * Class InsertCollection
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class InsertCollection extends AbstractDiffElement
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
    private $insertedElements = [];

    /**
     * Возвращает элементы добавленной коллекции
     *
     * @return InsertElement[]
     */
    public function getInsertedElements()
    {
        return $this->insertedElements;
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
     * @param DiffElementBuilder $diffBuilder
     */
    public function __construct(DiffElementBuilder $diffBuilder)
    {
        $this->insertedCollection = $diffBuilder->getTargetElement();

        parent::__construct($diffBuilder);
    }
}
