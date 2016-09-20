<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;

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
     * AbstractDiff constructor.
     *
     * @param \Nnx\FormComparator\Comparator\DiffElementBuilder $builder
     */
    public function __construct(DiffElementBuilder $builder)
    {
        $this->pathToElement = $builder->getPathToElement();

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



}
