<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;


use Nnx\FormComparator\Comparator\CollectionDiffService\HashElementBuilder;
use Webmozart\Assert\Assert;
use Zend\Form\Element\Collection;
use Zend\Form\ElementInterface;


/**
 * Class CollectionDiffService
 *
 * @package Nnx\FormComparator\Comparator
 */
class CollectionDiffService
{
    /**
     * Компоент отвечающий за подготовку хеша элемента
     *
     * @var HashElementBuilder
     */
    private $hashElementBuilder;

    /**
     * Возвращает компоент отвечающий за подготовку хеша элемента
     *
     * @return HashElementBuilder
     */
    public function getHashElementBuilder()
    {
        if (null === $this->hashElementBuilder) {
            $this->hashElementBuilder = new HashElementBuilder();
        }
        return $this->hashElementBuilder;
    }

    /**
     * Устанавливает компоент отвечающий за подготовку хеша элемента
     *
     * @param HashElementBuilder $hashElementBuilder
     *
     * @return $this
     */
    public function setHashElementBuilder(HashElementBuilder $hashElementBuilder)
    {
        $this->hashElementBuilder = $hashElementBuilder;

        return $this;
    }


    /**
     * Получение расхождения элементов меджу двумя коллекциями
     *
     * @param Collection    $sourceCollection
     * @param Collection    $targetCollection
     *
     * @param               $prefixPath
     *
     * @return mixed
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    public function buildDiff(Collection $sourceCollection, Collection $targetCollection, $prefixPath)
    {
        Assert::string($prefixPath);
        Assert::notEmpty($prefixPath);

        $sourceCollectionElementsHash = $this->buildHashForCollectionElements($sourceCollection);
        $targetCollectionElementsHash = $this->buildHashForCollectionElements($targetCollection);


        return;
    }

    /**
     * @param Collection $collection
     *
     *
     * @return array
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    protected function buildHashForCollectionElements(Collection $collection)
    {
        $order = 0;
        $hashForCollectionElements = [];
        $hashElementBuilder = $this->getHashElementBuilder();

        foreach ($collection->getIterator() as $elementOrFieldset) {
            /** @var ElementInterface $elementOrFieldset */
            Assert::isInstanceOf($elementOrFieldset, ElementInterface::class);
            $hashForCollectionElements[$order] = $hashElementBuilder->hash($elementOrFieldset);
            $order++;
        }

        return $hashForCollectionElements;
    }


}
