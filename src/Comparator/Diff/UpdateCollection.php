<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Nnx\FormComparator\Comparator\DiffElementBuilder;
use Zend\Form\Element\Collection;

/**
 * Class UpdateCollection
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class UpdateCollection extends AbstractDiffElement implements UpdatedElementInterface
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
     * @var AbstractCollectionElement[]
     */
    private $diff = [];

    /**
     * UpdateCollection constructor.
     *
     * @param DiffElementBuilder $diffBuilder
     */
    public function __construct(DiffElementBuilder $diffBuilder)
    {
        $this->sourceCollection = $diffBuilder->getSourceElement();
        $this->targetCollection = $diffBuilder->getTargetElement();
        $this->diff = $diffBuilder->getCollectionElementsDiff();

        parent::__construct($diffBuilder);
    }

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
     * @return AbstractCollectionElement[]
     */
    public function getDiff()
    {
        return $this->diff;
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
        return self::UPDATE;
    }
}
