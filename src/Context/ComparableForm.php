<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Context;

use Zend\Form\FormInterface;

/**
 * Class ComparableForm
 *
 * @package Nnx\FormComparator\Context
 */
class ComparableForm
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
     * ComparableForm constructor.
     *
     * @param FormInterface $sourceForm
     * @param FormInterface $targetForm
     */
    public function __construct(FormInterface $sourceForm, FormInterface $targetForm)
    {
        $this->sourceForm = $sourceForm;
        $this->targetForm = $targetForm;
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
}
