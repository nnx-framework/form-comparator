<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\Diff;
use Nnx\FormComparator\Comparator\DiffCollectionElementBuilder;
use Zend\Form\ElementInterface;

/**
 * Class UpdateCollectionElement
 *
 * @package Nnx\FormComparator\Comparator\Diff
 */
class UpdateCollectionElement extends AbstractCollectionElement
{
    /**
     * Хеш значения элемента коллекции с которым сравнивают
     *
     * @var string
     */
    private $targetHash;

    /**
     * Элемент коллекции с которым сравнивают
     *
     * @var ElementInterface
     */
    private $targetCollectionElement;

    /***
     * UpdateCollectionElement constructor.
     *
     * @param DiffCollectionElementBuilder $builder
     */
    public function __construct(DiffCollectionElementBuilder $builder)
    {
        $this->targetHash = $builder->getTargetHash();
        $this->targetCollectionElement = $builder->getTargetCollectionElement();

        parent::__construct($builder);
    }


    /**
     * @return string
     */
    public function getTargetHash()
    {
        return $this->targetHash;
    }

    /**
     * @return ElementInterface
     */
    public function getTargetCollectionElement()
    {
        return $this->targetCollectionElement;
    }

    

}
