<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;
use Webmozart\Assert\Assert;
use Zend\Form\ElementInterface;
use Zend\Form\FormInterface;

/**
 * Class DiffBuilder
 *
 * @package Nnx\FormComparator\Comparator
 */
class DiffBuilder
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
     * Элемент который сравнивают
     *
     * @return ElementInterface
     */
    public function getSourceElement()
    {
        return $this->sourceElement;
    }

    /**
     * Элемент с которым сравнивают
     *
     * @return ElementInterface
     */
    public function getTargetElement()
    {
        return $this->targetElement;
    }

    /**
     *  Устанавливает элемент который сравнивают
     *
     * @param ElementInterface $sourceElement
     *
     * @return $this
     */
    public function setSourceElement($sourceElement)
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
    public function setTargetElement($targetElement)
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
        return $this->sourceForm;
    }

    /**
     * Возвращает форму с которой сравнивают
     *
     * @return FormInterface
     */
    public function getTargetForm()
    {
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
     */
    public function build()
    {
        if (self::DELETE_ELEMENT_MODE === $this->mode) {
            $diff = new Diff\DeleteElement($this);
        } elseif (self::INSERT_ELEMENT_MODE === $this->mode) {
            $diff = new Diff\InsertElement($this);
        } else {
            $diff = new Diff\UpdateElement($this);
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
        return $this->mode;
    }
}
