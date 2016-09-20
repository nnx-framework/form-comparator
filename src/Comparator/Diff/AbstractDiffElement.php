<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;

use Nnx\FormComparator\Comparator\AbstractDiff;
use Nnx\FormComparator\Comparator\DiffElementBuilder;
use Zend\Form\FormInterface;

/**
 * Class AllowFormTrait
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
abstract class AbstractDiffElement extends AbstractDiff
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
     * Заголовок сравниваемого элемента
     *
     * @var string
     */
    private $sourceLabel;

    /**
     * DeleteElement constructor.
     *
     * @param DiffElementBuilder $diffBuilder
     */
    public function __construct(DiffElementBuilder $diffBuilder)
    {
        $this->sourceForm = $diffBuilder->getSourceForm();
        $this->targetForm = $diffBuilder->getTargetForm();
        $this->sourceLabel = $diffBuilder->getSourceLabel();

        parent::__construct($diffBuilder);
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

    /**
     * Заголовок сравниваемого элемента
     *
     * @return string
     */
    public function getSourceLabel()
    {
        return $this->sourceLabel;
    }
}
