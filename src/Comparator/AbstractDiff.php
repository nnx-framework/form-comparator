<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;
use Zend\Form\FormInterface;

/**
 * Class AbstractDiff
 *
 * @package Nnx\FormComparator\Comparator
 */
abstract class AbstractDiff
{
    /**
     * Путь до элемента
     *
     * @var string
     */
    private $pathToElement;

    /**
     * Заголовок сравниваемого элемента
     *
     * @var string
     */
    private $sourceLabel;

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
     * AbstractDiff constructor.
     *
     * @param \Nnx\FormComparator\Comparator\DiffBuilder $builder
     */
    public function __construct(DiffBuilder $builder)
    {
        $this->pathToElement = $builder->getPathToElement();
        $this->sourceLabel = $builder->getSourceLabel();
        $this->sourceForm = $builder->getSourceForm();
        $this->targetForm = $builder->getTargetForm();
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

    /**
     * Заголовок сравниваемого элемента
     *
     * @return string
     */
    public function getSourceLabel()
    {
        return $this->sourceLabel;
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
     * Устанавливает форму которую сравнивают
     *
     * @param FormInterface $sourceForm
     *
     * @return $this
     */
    public function setSourceForm($sourceForm)
    {
        $this->sourceForm = $sourceForm;

        return $this;
    }

    /**
     * Возвращает форму  с которой сравнивают
     *
     * @return FormInterface
     */
    public function getTargetForm()
    {
        return $this->targetForm;
    }

    /**
     * Устанавливает форму  с которой сравнивают
     *
     * @param FormInterface $targetForm
     *
     * @return $this
     */
    public function setTargetForm($targetForm)
    {
        $this->targetForm = $targetForm;

        return $this;
    }
}
