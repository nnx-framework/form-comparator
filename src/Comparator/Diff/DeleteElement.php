<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;


use Nnx\FormComparator\Comparator\DiffElementBuilder;
use Zend\Form\ElementInterface;

/**
 * Class DeleteElement
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class DeleteElement extends AbstractDiffElement implements DeletedElementInterface
{
    /**
     * Удаленный элемент
     *
     * @var ElementInterface
     */
    private $deletedElement;

    /**
     * Возвращает удаленный элемент (есть в форме которую сравнивают, но отсутствует в форме с которой сравнивают)
     *
     * @return ElementInterface
     */
    public function getDeletedElement()
    {
        return $this->deletedElement;
    }

    /**
     * DeleteElement constructor.
     *
     * @param DiffElementBuilder $diffBuilder
     */
    public function __construct(DiffElementBuilder $diffBuilder)
    {
        $this->deletedElement = $diffBuilder->getSourceElement();


        parent::__construct($diffBuilder);
    }

    /**
     * Определяет является ли diff для коллекции или для элемента формы
     *
     * @return bool
     */
    public function isCollection()
    {
        return false;
    }


    /**
     * Определяет какое действие было соверешенно с элементом (элемент был добавлен, изменен, удален)
     *
     * @return bool
     */
    public function getMode()
    {
        return self::DELETE;
    }
}


