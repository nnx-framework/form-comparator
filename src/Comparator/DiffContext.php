<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;

use Webmozart\Assert\Assert;
use Zend\Form\Element\Collection;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;

/**
 * Class DiffContext
 *
 * @package Nnx\FormComparator\Comparator
 */
class DiffContext
{
    /**
     * Элемент который сравнивают
     *
     * @var ElementInterface
     */
    private $source;

    /**
     * Элемент с которым сравнивают
     *
     * @var ElementInterface
     */
    private $target;

    /**
     * @var AbstractDiff[]
     */
    private $diff = [];

    /**
     * Определяет путь до элементов которые в данный момент сравниваются
     *
     * @var string
     */
    private $prefixPath;

    /**
     * FormDiffBuilderContext constructor.
     *
     * @param ElementInterface $source
     * @param ElementInterface $target
     *
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     */
    public function __construct(ElementInterface $source, ElementInterface $target)
    {
        $this->setComparableElements($source, $target);

        $this->prefixPath = $source->getName();

    }

    /**
     * Определяет путь до элементов которые в данный момент сравниваются
     *
     * @param string $prefixPath
     *
     * @return $this
     */
    public function setPrefixPath($prefixPath)
    {
        $this->prefixPath = $prefixPath;

        return $this;
    }


    /**
     * Устанавливает сравниваемые элементы
     *
     * @param ElementInterface $source
     * @param ElementInterface $target
     *
     *
     * @return $this
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     */
    public function setComparableElements(ElementInterface $source = null, ElementInterface $target = null)
    {
        $this->source = $source;
        $this->target = $target;

        if (null !== $source && null  !== $target) {
            $sourceName = $this->source->getName();
            $targetName = $this->target->getName();

            Assert::eq($sourceName, $targetName);

            $this->validateElementType($source, $target);
        }

        return $this;
    }


    /**
     * Проверка того что элементы совпадают по типам.
     *
     * Т.е. если сравниваемый элемент является коллекцией, то и элемент с которым сравнивают должен быть коллекцией.
     * Если сравниваемый элемент является Fieldset'ом, то и элемент с которым сравнивают должен быть Fieldset'ом
     *
     * @param ElementInterface $sourceElement
     * @param ElementInterface $targetElement
     *
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     */
    protected function validateElementType(ElementInterface $sourceElement, ElementInterface $targetElement)
    {
        $baseType = ElementInterface::class;
        if ($sourceElement instanceof Collection) {
            $baseType = Collection::class;
        } elseif ($sourceElement instanceof FieldsetInterface) {
            $baseType = FieldsetInterface::class;
        }

        if (!$targetElement instanceof $baseType) {
            $targetElementName = $targetElement->getName();
            $targetElementClass = get_class($targetElement);
            $errMsg = sprintf(
                'Element %s not implement %s',
                is_string($targetElementName) ? sprintf('%s(%s)', $targetElementName, $targetElementClass) : $targetElementClass,
                $baseType
            );
            throw new Exception\IncorrectElementTypeException($errMsg);
        }
    }

    /**
     * Элемент который сравнивают
     *
     * @return ElementInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Элемент с которым сравнивают
     *
     * @return ElementInterface
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Добавляет объект описывающий различия между двумя элементами формы
     *
     * @param AbstractDiff $diff
     *
     * @return $this
     */
    public function addDiff(AbstractDiff $diff)
    {
        $this->diff[] = $diff;

        return $this;
    }

    /**
     * Возвращает объекты описывающие различия между двумя элементами формы
     *
     * @return AbstractDiff[]
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * Возвращает путь до элементов которые в данный момент сравниваются
     *
     * @return string
     */
    public function getPrefixPath()
    {
        return $this->prefixPath;
    }



}
