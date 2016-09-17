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
     * @param $formName - имя формы (должна быть зарегестрирована в FormElementManager)
     * @param $object1 - первая версия объекта данные из которого накладываются на фомру
     * @param $object2 - вторая версия объекта данные из которого накладываются на фомру
     */
    public function addFormForCompare($formName, $object1, $object2)
    {
        Assert::string($formName, 'Form name not string');
        Assert::notEmpty($formName, 'Form name is empty');

        Assert::object($object1, 'Data for form(v1) not object');
        Assert::object($object2, 'Data for form(v2) not object');

        /** @var FormInterface $form1 */
        $form1 = $this->formElementManager->get($formName);
        Assert::isInstanceOf($form1, FormInterface::class, sprintf('%s not implement %s', $formName, FormInterface::class));

        /** @var FormInterface $form2 */
        $form2 = $this->formElementManager->get($formName);

        $form1->bind($object1);
        $form2->bind($object2);

        $this->comparableForm[] = new ComparableForm($form1, $form2);
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
