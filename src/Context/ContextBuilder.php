<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Context;

use Webmozart\Assert\Assert;
use Zend\Form\FormElementManager;
use Zend\Form\FormInterface;

/**
 * Class ContextBuilder
 *
 * @package Nnx\FormComparator\Context
 */
class ContextBuilder
{
    /**
     * Массив объектов, каждый из которых содержит информацию о том какие формы необходимо сравнивать
     *
     * @var ComparableForm[]
     */
    private $comparableForm = [];

    /**
     * @var FormElementManager
     */
    private $formElementManager;

    /**
     * ContextBuilder constructor.
     *
     * @param FormElementManager $formElementManager
     */
    public function __construct(FormElementManager $formElementManager)
    {
        $this->formElementManager = $formElementManager;
    }

    /**
     * Добавить информацию для сравнения форм, полученных в результате наложения информацию из двух разных объектов, на
     * заданную форму
     *
     * @param $formName     - имя формы (должна быть зарегестрирована в FormElementManager)
     * @param $sourceObject - первая версия объекта данные из которого накладываются на фомру
     * @param $targetObject - вторая версия объекта данные из которого накладываются на фомру
     *
     * @return $this
     */
    public function addFormForCompare($formName, $sourceObject, $targetObject)
    {
        Assert::string($formName, 'Form name not string');
        Assert::notEmpty($formName, 'Form name is empty');

        Assert::object($sourceObject, 'Data for form(v1) not object');
        Assert::object($targetObject, 'Data for form(v2) not object');

        /** @var FormInterface $sourceForm */
        $sourceForm = $this->formElementManager->get($formName);
        Assert::isInstanceOf($sourceForm, FormInterface::class, sprintf('%s not implement %s', $formName, FormInterface::class));

        /** @var FormInterface $targetForm */
        $targetForm = $this->formElementManager->get($formName);

        $sourceForm->bind($sourceObject);
        $targetForm->bind($targetObject);

        $this->addComparableForm($sourceForm, $targetForm);

        return $this;
    }

    /**
     * Добавляет две формы для сравнения
     *
     * @param FormInterface $sourceForm
     * @param FormInterface $targetForm
     *
     * @return $this
     */
    public function addComparableForm(FormInterface $sourceForm, FormInterface $targetForm)
    {
        $this->comparableForm[] = new ComparableForm($sourceForm, $targetForm);

        return $this;
    }

    /**
     * Создает контекст для сервиса сравнивающего формы
     *
     * @return Context
     */
    public function build()
    {
        return new Context($this);
    }

    /**
     * Массив объектов, каждый из которых содержит информацию о том какие формы необходимо сравнивать
     *
     * @return ComparableForm[]
     */
    public function getComparableForm()
    {
        return $this->comparableForm;
    }

}
