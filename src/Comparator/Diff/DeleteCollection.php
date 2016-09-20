<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Nnx\FormComparator\Comparator\DiffElementBuilder;
use Zend\Form\Element\Collection;

/**
 * Class DeleteCollection
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class DeleteCollection extends AbstractDiffElement implements DeletedElementInterface
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
    private $deletedElements = [];

    /**
     * Возвращает элементы удаленной коллекции
     *
     * @return DeleteElement[]
     */
    public function getDeletedElements()
    {
        return $this->deletedElements;
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
     * @param DiffElementBuilder $diffBuilder
     */
    public function __construct(DiffElementBuilder $diffBuilder)
    {
        $this->deletedCollection = $diffBuilder->getTargetElement();

        parent::__construct($diffBuilder);
    }


    /**
     * Определяет является ли diff для коллекции или для элемента формы
     *
     * @return bool
     */
    public function isCollection()
    {
        return true;
    }


    /**
     * Определяет какое действие было соверешенно с элементом (элемент был добавлен, изменен, удален)
     *
     * @return bool
     */
    public function getMode()
    {
        return self::DELETE;
    }
}
