<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Zend\Form\ElementInterface;
use Nnx\FormComparator\Comparator\DiffCollectionElementBuilder;

/**
 * Class AbstractCollectionElement
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
abstract class AbstractCollectionElement
{
    /**
     * Порядковый номер элмента коллекции
     *
     * @var integer
     */
    private $rowIndex;

    /**
     * Уникальный идендфификатор строки коллекци
     *
     * @var string
     */
    private $uniqueRowId;

    /**
     * Хеш значения элемента коллекции
     *
     * @var string
     */
    private $sourceHash;

    /**
     * Элемент коллекции 
     *
     * @var ElementInterface
     */
    private $sourceCollectionElement;

    /**
     * Путь до элемента
     *
     * @var string
     */
    private $pathToElement;

    /**
     * AbstractCollectionElement constructor.
     *
     * @param DiffCollectionElementBuilder $builder
     */
    public function __construct(DiffCollectionElementBuilder $builder)
    {
        $this->rowIndex = $builder->getRowIndex();
        $this->uniqueRowId = $builder->getUniqueRowId();
        $this->sourceHash = $builder->getSourceHash();
        $this->sourceCollectionElement = $builder->getSourceCollectionElement();
        $this->pathToElement = $builder->getPathToElement();
    }


    /**
     * Порядковый номер элмента коллекции
     *
     * @return int
     */
    public function getRowIndex()
    {
        return $this->rowIndex;
    }

    /**
     * Уникальный идендфификатор строки коллекци
     *
     * @return string
     */
    public function getUniqueRowId()
    {
        return $this->uniqueRowId;
    }

    /**
     * Хеш значения элемента коллекции
     *
     * @return string
     */
    public function getSourceHash()
    {
        return $this->sourceHash;
    }

    /**
     * Элемент коллекции
     *
     * @return ElementInterface
     */
    public function getSourceCollectionElement()
    {
        return $this->sourceCollectionElement;
    }

    /**
     * Возвращает путь до элемента
     *
     * @return string
     */
    public function getPathToElement()
    {
        return $this->pathToElement;
    }
}
