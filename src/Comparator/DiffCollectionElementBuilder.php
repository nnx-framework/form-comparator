<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;


use Webmozart\Assert\Assert;
use Zend\Form\ElementInterface;


/**
 * Class DiffCollectionElementBuilder
 *
 * @package Nnx\FormComparator\Comparator
 */
class DiffCollectionElementBuilder
{
    /**
     * Элемент был создан
     *
     * @var string
     */
    const INSERT_ELEMENT_MODE = 'insertElement';

    /**
     * Элемент был удален
     *
     * @var string
     */
    const DELETE_ELEMENT_MODE = 'deleteElement';

    /**
     * Элемент был изменен
     *
     * @var string
     */
    const UPDATE_ELEMENT_MODE = 'updateElement';

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
     * Хеш значения элемента коллекции который сравнивают
     *
     * @var string
     */
    private $sourceHash;

    /**
     * Хеш значения элемента коллекции с которым сравнивают
     *
     * @var string
     */
    private $targetHash;

    /**
     * Элемент коллекции  который сравнивают
     *
     * @var ElementInterface
     */
    private $sourceCollectionElement;

    /**
     * Элемент коллекции с которым сравнивают
     *
     * @var ElementInterface
     */
    private $targetCollectionElement;

    /**
     * Определяет какой объект создавать
     *
     * @var string
     */
    private $mode;

    /**
     * Путь до элемента
     *
     * @var string
     */
    private $pathToElement;

    /**
     * Допустимые режимы
     *
     * @var array
     */
    private $accessMode = [
        self::DELETE_ELEMENT_MODE => self::DELETE_ELEMENT_MODE,
        self::UPDATE_ELEMENT_MODE => self::UPDATE_ELEMENT_MODE,
        self::INSERT_ELEMENT_MODE => self::INSERT_ELEMENT_MODE,
    ];

    /**
     * DiffBuilder constructor.
     *
     * @param string $mode
     */
    public function __construct($mode)
    {
        Assert::keyExists($this->accessMode, $mode);
        $this->mode = $mode;
    }

    /**
     * Создает объект описывающий различие между двумя элементами формы
     *
     * @return AbstractDiff
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    public function build()
    {
        switch ($this->mode) {
            case self::DELETE_ELEMENT_MODE:
                $diff = new Diff\DeletedCollectionElement($this);
                break;
            case self::INSERT_ELEMENT_MODE:
                $diff = new Diff\InsertCollectionElement($this);
                break;
            case self::UPDATE_ELEMENT_MODE:
                $diff = new Diff\UpdateCollectionElement($this);
                break;
            default:
                throw new Exception\DomainException(sprintf('Unknown mode %s', $this->mode));

        }

        return $diff;
    }

    /**
     * Определяет какой объект создавать
     *
     * @return string
     */
    public function getMode()
    {
        Assert::string($this->mode);
        Assert::notEmpty($this->mode);
        return $this->mode;
    }


    /**
     * Порядковый номер элмента коллекции
     *
     * @return int
     */
    public function getRowIndex()
    {
        Assert::integer($this->rowIndex);
        return $this->rowIndex;
    }

    /**
     * Уникальный идендфификатор строки коллекци
     *
     * @return string
     */
    public function getUniqueRowId()
    {
        Assert::numeric($this->uniqueRowId);
        return $this->uniqueRowId;
    }

    /**
     * Хеш значения элемента коллекции который сравнивают
     *
     * @return string
     */
    public function getSourceHash()
    {
        Assert::string($this->sourceHash);
        Assert::notEmpty($this->sourceHash);
        return $this->sourceHash;
    }

    /**
     * Элемент коллекции  который сравнивают
     *
     * @return ElementInterface
     */
    public function getSourceCollectionElement()
    {
        Assert::isInstanceOf($this->sourceCollectionElement, ElementInterface::class);
        return $this->sourceCollectionElement;
    }


    /**
     * Путь до элемента
     *
     * @return string
     */
    public function getPathToElement()
    {
        Assert::string($this->pathToElement);
        Assert::notEmpty($this->pathToElement);
        return $this->pathToElement;
    }

    /**
     * Уникальный идендфификатор строки коллекци
     *
     * @param string $uniqueRowId
     *
     * @return $this
     */
    public function setUniqueRowId($uniqueRowId)
    {
        $this->uniqueRowId = $uniqueRowId;

        return $this;
    }

    /**
     * Хеш значения элемента коллекции который сравнивают
     *
     * @param string $sourceHash
     *
     * @return $this
     */
    public function setSourceHash($sourceHash)
    {
        $this->sourceHash = $sourceHash;

        return $this;
    }

    /**
     * Устанавливает элемент коллекции  который сравнивают
     *
     * @param ElementInterface $sourceCollectionElement
     *
     * @return $this
     */
    public function setSourceCollectionElement(ElementInterface $sourceCollectionElement)
    {
        $this->sourceCollectionElement = $sourceCollectionElement;

        return $this;
    }

    /**
     * Путь до элемента
     *
     * @param string $pathToElement
     *
     * @return $this
     */
    public function setPathToElement($pathToElement)
    {
        $this->pathToElement = $pathToElement;

        return $this;
    }

    /**
     * Порядковый номер элмента коллекции
     *
     * @param int $rowIndex
     *
     * @return $this
     */
    public function setRowIndex($rowIndex)
    {
        $this->rowIndex = $rowIndex;

        return $this;
    }

    /**
     * Хеш значения элемента коллекции с которым сравнивают
     *
     * @return string
     */
    public function getTargetHash()
    {
        return $this->targetHash;
    }

    /**
     * Хеш значения элемента коллекции с которым сравнивают
     *
     * @param string $targetHash
     *
     * @return $this
     */
    public function setTargetHash($targetHash)
    {
        $this->targetHash = $targetHash;

        return $this;
    }

    /**
     * Элемент коллекции с которым сравнивают
     *
     * @return ElementInterface
     */
    public function getTargetCollectionElement()
    {
        return $this->targetCollectionElement;
    }

    /**
     * Устанавливает элемент коллекции с которым сравнивают
     *
     * @param ElementInterface $targetCollectionElement
     *
     * @return $this
     */
    public function setTargetCollectionElement(ElementInterface $targetCollectionElement)
    {
        $this->targetCollectionElement = $targetCollectionElement;

        return $this;
    }




}
