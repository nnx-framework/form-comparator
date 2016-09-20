<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator;


use Nnx\FormComparator\Comparator\CollectionDiffService\HashElementBuilder;
use Nnx\FormComparator\Comparator\Diff\DeletedCollectionElement;
use Nnx\FormComparator\Comparator\Diff\InsertCollectionElement;
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
     * Подготавливает объекты описывающие элементы добавленной коллекции
     *
     * @param Collection $insertedCollection
     * @param            $prefixPath
     *
     * @return InsertCollectionElement[]
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    public function buildDiffInsertedCollection(Collection $insertedCollection, $prefixPath)
    {
        Assert::string($prefixPath);
        Assert::notEmpty($prefixPath);

        $collectionElementsInfo = $this->buildInfoForCollectionElements($insertedCollection, $prefixPath);

        $diff = [];

        foreach ($collectionElementsInfo  as $rowUniqueId => $info) {
            $builder = $this->diffCollectionElementBuilderFactory(DiffCollectionElementBuilder::INSERT_ELEMENT_MODE);
            $builder->setSourceHash($info['hash'])
                ->setRowIndex($info['rowIndex'])
                ->setSourceCollectionElement($info['element'])
                ->setUniqueRowId($info['rowUniqueId'])
                ->setPathToElement($info['pathToElement']);
            $diff[] = $builder->build();
        }

        return $diff;
    }

    /**
     * Подготавливает объекты описывающие элементы удаленной коллекции
     *
     * @param Collection $deletedCollection
     * @param            $prefixPath
     *
     * @return DeletedCollectionElement[]
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    public function buildDiffDeletedCollection(Collection $deletedCollection, $prefixPath)
    {
        Assert::string($prefixPath);
        Assert::notEmpty($prefixPath);

        $collectionElementsInfo = $this->buildInfoForCollectionElements($deletedCollection, $prefixPath);

        $diff = [];

        foreach ($collectionElementsInfo  as $rowUniqueId => $info) {
            $builder = $this->diffCollectionElementBuilderFactory(DiffCollectionElementBuilder::DELETE_ELEMENT_MODE);
            $builder->setSourceHash($info['hash'])
                ->setRowIndex($info['rowIndex'])
                ->setSourceCollectionElement($info['element'])
                ->setUniqueRowId($info['rowUniqueId'])
                ->setPathToElement($info['pathToElement']);
            $diff[] = $builder->build();
        }

        return $diff;
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
     * @throws \Nnx\FormComparator\Comparator\Exception\DomainException
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    public function buildDiffUpdatedCollection(Collection $sourceCollection, Collection $targetCollection, $prefixPath)
    {
        Assert::string($prefixPath);
        Assert::notEmpty($prefixPath);

        $sourceCollectionElementsInfo = $this->buildInfoForCollectionElements($sourceCollection, $prefixPath);
        $targetCollectionElementsInfo = $this->buildInfoForCollectionElements($targetCollection, $prefixPath);


        $diff = [];
        foreach ($sourceCollectionElementsInfo as $rowUniqueId => $sourceInfo) {
            if (array_key_exists($rowUniqueId, $targetCollectionElementsInfo)) {
                $targetInfo = $targetCollectionElementsInfo[$rowUniqueId];
                if ($sourceInfo['hash'] !== $targetInfo['hash']) {
                    $builder = $this->diffCollectionElementBuilderFactory(DiffCollectionElementBuilder::UPDATE_ELEMENT_MODE);
                    $builder->setSourceHash($sourceInfo['hash'])
                            ->setTargetHash($targetInfo['hash'])
                            ->setRowIndex($sourceInfo['rowIndex'])
                            ->setSourceCollectionElement($sourceInfo['element'])
                            ->setTargetCollectionElement($targetInfo['element'])
                            ->setUniqueRowId($targetInfo['rowUniqueId'])
                            ->setPathToElement($targetInfo['pathToElement']);
                    $diff[] = $builder->build();
                }
            } else {
                $builder = $this->diffCollectionElementBuilderFactory(DiffCollectionElementBuilder::DELETE_ELEMENT_MODE);
                $builder->setSourceHash($sourceInfo['hash'])
                    ->setRowIndex($sourceInfo['rowIndex'])
                    ->setSourceCollectionElement($sourceInfo['element'])
                    ->setUniqueRowId($sourceInfo['rowUniqueId'])
                    ->setPathToElement($sourceInfo['pathToElement']);
                $diff[] = $builder->build();
            }
        }

        foreach ($targetCollectionElementsInfo as $rowUniqueId => $targetInfo) {
            if (!array_key_exists($rowUniqueId, $sourceCollectionElementsInfo)) {
                $builder = $this->diffCollectionElementBuilderFactory(DiffCollectionElementBuilder::INSERT_ELEMENT_MODE);
                $builder->setSourceHash($targetInfo['hash'])
                    ->setRowIndex($targetInfo['rowIndex'])
                    ->setSourceCollectionElement($targetInfo['element'])
                    ->setUniqueRowId($targetInfo['rowUniqueId'])
                    ->setPathToElement($targetInfo['pathToElement']);
                $diff[] = $builder->build();
            }
        }


        return $diff;
    }

    /**
     * @param Collection $collection
     *
     *
     * @param            $prefixPath
     *
     * @return array
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    protected function buildInfoForCollectionElements(Collection $collection, $prefixPath)
    {
        $rowUniqueId = 0;
        $hashForCollectionElements = [];
        $hashElementBuilder = $this->getHashElementBuilder();

        foreach ($collection->getIterator() as $elementOrFieldset) {
            /** @var ElementInterface $elementOrFieldset */
            Assert::isInstanceOf($elementOrFieldset, ElementInterface::class);
            $hashForCollectionElements[$rowUniqueId] = [
                'hash' => $hashElementBuilder->hash($elementOrFieldset),
                'element' => $elementOrFieldset,
                'rowUniqueId' => $rowUniqueId,
                'rowIndex' => $rowUniqueId,
                'pathToElement' => $prefixPath . '.' . $elementOrFieldset->getName()
            ];
            $rowUniqueId++;
        }

        return $hashForCollectionElements;
    }


    /**
     * Билдер для получения объекта описывающего разницу в коллекции
     *
     * @param $mode
     *
     * @return DiffCollectionElementBuilder
     */
    protected function diffCollectionElementBuilderFactory($mode)
    {
        return new DiffCollectionElementBuilder($mode);
    }
}
