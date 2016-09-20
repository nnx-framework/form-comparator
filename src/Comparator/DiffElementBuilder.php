<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;
use Nnx\FormComparator\Comparator\Diff\AbstractCollectionElement;
use Webmozart\Assert\Assert;
use Zend\Form\Element\Collection;
use Zend\Form\ElementInterface;
use Zend\Form\FormInterface;

/**
 * Class DiffElementBuilder
 *
 * @package Nnx\FormComparator\Comparator
 */
class DiffElementBuilder
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
     * Элемент был создан
     *
     * @var string
     */
    const INSERT_COLLECTION_MODE = 'insertCollection';

    /**
     * Элемент был удален
     *
     * @var string
     */
    const DELETE_COLLECTION_MODE = 'deleteCollection';

    /**
     * Элемент был изменен
     *
     * @var string
     */
    const UPDATE_COLLECTION_MODE = 'updateCollection';

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
     * Заголовок элемента который сравнивают
     *
     * @var string
     */
    private $sourceLabel;

    /**
     * Значение элемента который сравнивают
     *
     * @var mixed
     */
    private $sourceValue;

    /**
     * Значение элемента с которым сравнивают
     *
     * @var mixed
     */
    private $targetValue;

    /**
     * Форма которую сравнивают
     *
     * @var FormInterface
     */
    private $sourceForm;

    /**
     * Форма с которой сравнивают
     *
     * @var FormInterface
     */
    private $targetForm;

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
     * @var AbstractCollectionElement[]
     */
    private $collectionElementsDiff;

    /**
     * Сервис для создания коллекции объектов описывающих разницу между коллекциями
     *
     * @var CollectionDiffService
     */
    private $collectionDiffService;

    /**
     * Допустимые режимы
     *
     * @var array
     */
    private $accessMode = [
        self::DELETE_ELEMENT_MODE => self::DELETE_ELEMENT_MODE,
        self::UPDATE_ELEMENT_MODE => self::UPDATE_ELEMENT_MODE,
        self::INSERT_ELEMENT_MODE => self::INSERT_ELEMENT_MODE,
        self::INSERT_COLLECTION_MODE => self::INSERT_COLLECTION_MODE,
        self::UPDATE_COLLECTION_MODE => self::UPDATE_COLLECTION_MODE,
        self::DELETE_COLLECTION_MODE => self::DELETE_COLLECTION_MODE,
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
     * Элемент который сравнивают
     *
     * @return ElementInterface
     */
    public function getSourceElement()
    {
        Assert::isInstanceOf($this->sourceElement, ElementInterface::class);
        return $this->sourceElement;
    }

    /**
     * Элемент с которым сравнивают
     *
     * @return ElementInterface
     */
    public function getTargetElement()
    {
        Assert::isInstanceOf($this->targetElement, ElementInterface::class);
        return $this->targetElement;
    }

    /**
     *  Устанавливает элемент который сравнивают
     *
     * @param ElementInterface $sourceElement
     *
     * @return $this
     */
    public function setSourceElement(ElementInterface $sourceElement)
    {
        $this->sourceElement = $sourceElement;

        return $this;
    }

    /**
     * Возвращает элемент который сравнивают
     *
     * @param ElementInterface $targetElement
     *
     * @return $this
     */
    public function setTargetElement(ElementInterface $targetElement)
    {
        $this->targetElement = $targetElement;

        return $this;
    }

    /**
     * Возвращает форму которую сравнивают
     *
     * @return FormInterface
     */
    public function getSourceForm()
    {
        Assert::isInstanceOf($this->targetForm, FormInterface::class);
        return $this->sourceForm;
    }

    /**
     * Возвращает форму с которой сравнивают
     *
     * @return FormInterface
     */
    public function getTargetForm()
    {
        Assert::isInstanceOf($this->targetForm, FormInterface::class);
        return $this->targetForm;
    }

    /**
     * Устанавливает форма которую сравнивают
     *
     * @param FormInterface $sourceForm
     *
     * @return $this
     */
    public function setSourceForm(FormInterface $sourceForm)
    {
        $this->sourceForm = $sourceForm;

        return $this;
    }

    /**
     * Устанавливает форму с которой сравнивают
     *
     * @param FormInterface $targetForm
     *
     * @return $this
     */
    public function setTargetForm(FormInterface $targetForm)
    {
        $this->targetForm = $targetForm;

        return $this;
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
     * Устанавливает путь до элемента
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
     * Заголовок элемента который сравнивают
     *
     * @return string
     */
    public function getSourceLabel()
    {
        return $this->sourceLabel;
    }

    /**
     * Устанавливают заголовок элемента который сравнивают
     *
     * @param string $sourceLabel
     *
     * @return $this
     */
    public function setSourceLabel($sourceLabel)
    {
        $this->sourceLabel = $sourceLabel;

        return $this;
    }

    /**
     * Значение элемента который сравнивают
     *
     * @return mixed
     */
    public function getSourceValue()
    {
        return $this->sourceValue;
    }

    /**
     * Устанавливает значение элемента который сравнивают
     *
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
     * Возвращают значение элемента с которым сравнивают
     *
     * @return mixed
     */
    public function getTargetValue()
    {
        return $this->targetValue;
    }

    /**
     * Устанавливают значение элемента с которым сравнивают
     *
     * @param mixed $targetValue
     *
     * @return $this
     */
    public function setTargetValue($targetValue)
    {
        $this->targetValue = $targetValue;

        return $this;
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
                $diff = new Diff\DeleteElement($this);
                break;
            case self::INSERT_ELEMENT_MODE:
                $diff = new Diff\InsertElement($this);
                break;
            case self::UPDATE_ELEMENT_MODE:
                $diff = new Diff\UpdateElement($this);
                break;
            case self::UPDATE_COLLECTION_MODE:
                $sourceCollection = $this->getSourceElement();
                $targetCollection = $this->getTargetElement();
                $prefixPath = $this->getPathToElement();
                if ($sourceCollection instanceof Collection && $targetCollection instanceof Collection) {
                    $this->collectionElementsDiff = $this->getCollectionDiffService()
                        ->buildDiffUpdatedCollection($sourceCollection, $targetCollection, $prefixPath);
                } else {
                    throw new Exception\DomainException('Invalid collections');
                }

                $diff = new Diff\UpdateCollection($this);
                break;
            case self::INSERT_COLLECTION_MODE:
                $sourceCollection = $this->getSourceElement();
                $prefixPath = $this->getPathToElement();
                if ($sourceCollection instanceof Collection) {
                    $this->collectionElementsDiff = $this->getCollectionDiffService()
                        ->buildDiffInsertedCollection($sourceCollection, $prefixPath);
                } else {
                    throw new Exception\DomainException('Invalid collections');
                }

                $diff = new Diff\InsertCollection($this);
                break;
            case self::DELETE_COLLECTION_MODE:
                $sourceCollection = $this->getSourceElement();
                $prefixPath = $this->getPathToElement();
                if ($sourceCollection instanceof Collection) {
                    $this->collectionElementsDiff = $this->getCollectionDiffService()
                        ->buildDiffDeletedCollection($sourceCollection, $prefixPath);
                } else {
                    throw new Exception\DomainException('Invalid collections');
                }

                $diff = new Diff\DeleteCollection($this);
                break;
            default:
                throw new Exception\DomainException(sprintf('Unknown mode %s', $this->mode));

        }

        return $diff;
    }

    /**
     * Возвращает объекты описывающие разницу между двумя коллекциями
     *
     * @return Diff\AbstractCollectionElement[]
     */
    public function getCollectionElementsDiff()
    {
        Assert::isArray($this->collectionElementsDiff);
        return $this->collectionElementsDiff;
    }
    
    /**
     * Определяет какой объект создавать
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Сервис для создания коллекции объектов описывающих разницу между коллекциями
     *
     * @return CollectionDiffService
     */
    protected function getCollectionDiffService()
    {
        if (null === $this->collectionDiffService) {
            $this->collectionDiffService = new CollectionDiffService();
        }
        return $this->collectionDiffService;
    }
}
