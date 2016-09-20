<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;


use Webmozart\Assert\Assert;
use Zend\Form\Element\Collection;
use Zend\Form\ElementInterface;
use Zend\Form\FormInterface;
use Zend\Form\FieldsetInterface;

/**
 * Class FormDiffService
 *
 * @package Nnx\FormComparator\Comparator
 */
class FormDiffService
{

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
     * Результаты сравнения
     *
     * @var AbstractDiff[]
     */
    private $diff = [];

    /**
     * Определение элементов которые отличаются в формах
     *
     * @param FormInterface $sourceForm
     * @param FormInterface $targetForm
     *
     * @return array
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     */
    public function buildDiff(FormInterface $sourceForm, FormInterface $targetForm)
    {

//        $sourceForm->get('sign')->get('signInfo')->add([
//            'name' => 'test',
//            'type' => 'datetime'
//        ]);
//
//        $targetForm->get('sign')->get('signInfo')->add([
//            'name' => 'test2',
//            'type' => 'datetime'
//        ]);

        $this->sourceForm = $sourceForm;
        $this->targetForm = $targetForm;


        $this->runBuildDiffFieldset($sourceForm, $targetForm);
        $diff = $this->diff;
        $this->diff = [];

        $this->sourceForm = null;
        $this->targetForm = null;


        return $diff;
    }


    /**
     * Запускает сравнение двух Fieldset'ов
     *
     * @param FieldsetInterface $sourceForm
     * @param FieldsetInterface $targetForm
     *
     * @return AbstractDiff[]
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     */
    protected function runBuildDiffFieldset(FieldsetInterface $sourceForm, FieldsetInterface $targetForm)
    {
        $prefixPath = $sourceForm->getName();
        $this->buildDiffFieldset($sourceForm, $targetForm, $prefixPath);
        $this->addNewElementInDiff($sourceForm, $targetForm, $prefixPath);
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
     * Подготавливает список изменнные элементов для двух Fieldset'ов формы
     *
     *
     * @param FieldsetInterface $sourceFieldset
     * @param FieldsetInterface $targetFieldset
     * @param                   $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function buildDiffFieldset(FieldsetInterface $sourceFieldset, FieldsetInterface $targetFieldset, $prefixPath)
    {
        Assert::string($prefixPath);
        Assert::notEmpty($prefixPath);

        foreach ($sourceFieldset->getIterator() as $childSourceElementOrFieldset) {
            /** @var ElementInterface $childSourceElementOrFieldset */
            Assert::isInstanceOf($childSourceElementOrFieldset, ElementInterface::class);
            $childSourceElementOrFieldsetName = $childSourceElementOrFieldset->getName();

            $pathToElement = $this->buildPathToElementOrFieldset($childSourceElementOrFieldsetName, $prefixPath);
            if ($targetFieldset->has($childSourceElementOrFieldsetName)) {
                $childTargetElementOrFieldset = $targetFieldset->get($childSourceElementOrFieldsetName);
                $this->runDiffElementStrategy($childSourceElementOrFieldset, $childTargetElementOrFieldset, $pathToElement);
            } else {
                $this->runDeleteElementStrategy($childSourceElementOrFieldset, $pathToElement);
            }
        }
    }

    /**
     * @param ElementInterface $insertedElement
     * @param                  $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function createInsertedElementDiff(ElementInterface $insertedElement, $prefixPath)
    {
        $builder = $this->diffBuilderFactory(DiffElementBuilder::INSERT_ELEMENT_MODE);
        $builder->setPathToElement($prefixPath)
            ->setTargetElement($insertedElement)
            ->setSourceLabel($insertedElement->getLabel());

        $this->diff[] = $builder->build();
    }


    /**
     * Строит объект описывающий различия для двух изменныех элементов форм
     *
     * @param ElementInterface $sourceElement
     * @param ElementInterface $targetElement
     * @param                  $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function buildDiffElementValue(ElementInterface $sourceElement, ElementInterface $targetElement, $prefixPath)
    {

        $sourceElementValue = $sourceElement->getValue();
        $targetElementValue = $targetElement->getValue();

        if ($sourceElementValue !== $targetElementValue) {
            $pathToElement = $this->buildPathToElementOrFieldset($sourceElement->getName(), $prefixPath);

            $builder = $this->diffBuilderFactory(DiffElementBuilder::UPDATE_ELEMENT_MODE);

            $builder->setPathToElement($pathToElement)
                ->setSourceLabel($sourceElement->getLabel())
                ->setSourceValue($sourceElementValue)
                ->setTargetValue($targetElementValue)
                ->setSourceElement($sourceElement)
                ->setTargetElement($targetElement);

            $this->diff[] = $builder->build();
        }
    }


    /**
     * @param FieldsetInterface $sourceFieldset
     * @param FieldsetInterface $targetFieldset
     * @param                   $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function addNewElementInDiff(FieldsetInterface $sourceFieldset, FieldsetInterface $targetFieldset, $prefixPath)
    {
        foreach ($targetFieldset->getIterator() as $childTargetElementOrFieldset) {
            /** @var ElementInterface $childTargetElementOrFieldset */
            Assert::isInstanceOf($childTargetElementOrFieldset, ElementInterface::class);

            $childTargetFieldsetName = $childTargetElementOrFieldset->getName();
            $pathToElementOrFieldset = $this->buildPathToElementOrFieldset($childTargetFieldsetName, $prefixPath);

            if ($sourceFieldset->has($childTargetFieldsetName)) {
                /** @var FieldsetInterface $childSourceFieldset */
                $childSourceFieldset = $sourceFieldset->get($childTargetFieldsetName);

                if ($this->isRunAddNewElementInDiff($childSourceFieldset, $childTargetElementOrFieldset)) {
                    /** @var FieldsetInterface $childTargetElementOrFieldset */
                    $this->addNewElementInDiff($childSourceFieldset, $childTargetElementOrFieldset, $pathToElementOrFieldset);
                }

            } else {
                $this->runInsertedElementStrategy($childTargetElementOrFieldset, $pathToElementOrFieldset);
            }
        }
    }

    /**
     * Проверяет нужно ли продолжать добавление новых элементов
     *
     * @param ElementInterface $sourceElement
     * @param ElementInterface $targetElement
     *
     * @return bool
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     */
    protected function isRunAddNewElementInDiff(ElementInterface $sourceElement, ElementInterface $targetElement)
    {
        $this->validateElementType($sourceElement, $targetElement);

        if ($sourceElement instanceof Collection && $targetElement instanceof Collection) {
            return false;
        } elseif ($sourceElement instanceof FieldsetInterface && $targetElement instanceof FieldsetInterface) {
            return true;
        }

        return false;
    }

    /**
     * Помечает вложенные элемента Fieldset'a как удаленные
     *
     * @param FieldsetInterface $deletedFieldset
     * @param                   $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function markNestedElementsAsDeletedInFieldset(FieldsetInterface $deletedFieldset, $prefixPath)
    {
        foreach ($deletedFieldset->getIterator() as $childElementOrFieldset) {
            /** @var ElementInterface $childElementOrFieldset */
            Assert::isInstanceOf($childElementOrFieldset, ElementInterface::class);

            $childElementOrFieldsetName = $childElementOrFieldset->getName();
            $pathToDeletedElement = $this->buildPathToElementOrFieldset($childElementOrFieldsetName, $prefixPath);

            $this->runDeleteElementStrategy($childElementOrFieldset, $pathToDeletedElement);

        }
    }

    /**
     * Помечает вложенные элемента Fieldset'a как добавленные
     *
     * @param FieldsetInterface $insertedFieldset
     * @param                   $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function markNestedElementsAsInsertedInFieldset(FieldsetInterface $insertedFieldset, $prefixPath)
    {
        foreach ($insertedFieldset->getIterator() as $childElementOrFieldset) {
            /** @var ElementInterface $childElementOrFieldset */
            Assert::isInstanceOf($childElementOrFieldset, ElementInterface::class);

            $childElementOrFieldsetName = $childElementOrFieldset->getName();
            $pathToInsertedElement = $this->buildPathToElementOrFieldset($childElementOrFieldsetName, $prefixPath);
            $this->runInsertedElementStrategy($childElementOrFieldset, $pathToInsertedElement);
        }
    }


    /**
     * Создает diff - указывающий на то что элемент был удален
     *
     * @param ElementInterface $deletedElement
     * @param                  $pathToDeletedElement
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    public function createDeleteElementDiff(ElementInterface $deletedElement, $pathToDeletedElement)
    {
        $builder = $this->diffBuilderFactory(DiffElementBuilder::DELETE_ELEMENT_MODE);
        $builder->setPathToElement($pathToDeletedElement)
            ->setSourceElement($deletedElement)
            ->setSourceLabel($deletedElement->getLabel());

        $this->diff[] = $builder->build();
    }


    /**
     * Путь до элемента
     *
     * @param             $elementName
     * @param null|string $prefixPath
     *
     * @return string
     */
    protected function buildPathToElementOrFieldset($elementName, $prefixPath = null)
    {
        $pathToElement = $elementName;
        if (null !== $prefixPath) {
            $pathToElement = sprintf('%s.%s', $prefixPath, $elementName);
        }

        return $pathToElement;
    }

    /**
     * Создает билдер, используемый для того что бы построить объект в котором описываются различия между элементами
     * формы
     *
     * @param $mode
     *
     * @return DiffElementBuilder
     */
    protected function diffBuilderFactory($mode)
    {
        $builder = new DiffElementBuilder($mode);
        $builder->setSourceForm($this->sourceForm)
            ->setTargetForm($this->targetForm);

        return $builder;
    }

    /**
     * Определяет стратегию сравнения в зависимости от типа элемента
     *
     * @param ElementInterface $sourceElement
     * @param ElementInterface $targetElement
     * @param                  $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\Exception\IncorrectElementTypeException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function runDiffElementStrategy(ElementInterface $sourceElement, ElementInterface $targetElement, $prefixPath)
    {
        $this->validateElementType($sourceElement, $targetElement);

        if ($sourceElement instanceof Collection && $targetElement instanceof Collection) {

            $builder = $this->diffBuilderFactory(DiffElementBuilder::UPDATE_COLLECTION_MODE);
            $builder->setSourceElement($sourceElement)
                ->setTargetElement($targetElement)
                ->setSourceLabel($sourceElement->getLabel())
                ->setPathToElement($prefixPath);
            $this->diff[] = $builder->build();

        } elseif ($sourceElement instanceof FieldsetInterface && $targetElement instanceof FieldsetInterface) {
            $this->buildDiffFieldset($sourceElement, $targetElement, $prefixPath);
        } else {
            $this->buildDiffElementValue($sourceElement, $targetElement, $prefixPath);
        }
    }

    /**
     * Определяет стратегию для создания объекта описывающего изменения связанные с удалением элемента из формы, в
     * зависимости от типа элемента
     *
     * @param ElementInterface $deletedElement
     * @param                  $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function runDeleteElementStrategy(ElementInterface $deletedElement, $prefixPath)
    {
        if ($deletedElement instanceof Collection) {
            $builder = $this->diffBuilderFactory(DiffElementBuilder::DELETE_COLLECTION_MODE);
            $builder->setSourceElement($deletedElement)
                ->setSourceLabel($deletedElement->getLabel())
                ->setPathToElement($prefixPath);
            $this->diff[] = $builder->build();
        } elseif ($deletedElement instanceof FieldsetInterface) {
            $this->markNestedElementsAsDeletedInFieldset($deletedElement, $prefixPath);
        } else {
            $this->createDeleteElementDiff($deletedElement, $prefixPath);
        }
    }


    /**
     * В зависимости от типа элемента определяет стратегию для создания объекта описывающего изменения связанные
     * с добавлением элемента в форму
     *
     * @param ElementInterface $insertedElement
     * @param                  $prefixPath
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     */
    protected function runInsertedElementStrategy(ElementInterface $insertedElement, $prefixPath)
    {
        if ($insertedElement instanceof Collection) {
            $builder = $this->diffBuilderFactory(DiffElementBuilder::INSERT_COLLECTION_MODE);
            $builder->setSourceElement($insertedElement)
                ->setSourceLabel($insertedElement->getLabel())
                ->setPathToElement($prefixPath);
            $this->diff[] = $builder->build();
        } elseif ($insertedElement instanceof FieldsetInterface) {
            $this->markNestedElementsAsInsertedInFieldset($insertedElement, $prefixPath);
        } else {
            $this->createInsertedElementDiff($insertedElement, $prefixPath);
        }
    }
}
