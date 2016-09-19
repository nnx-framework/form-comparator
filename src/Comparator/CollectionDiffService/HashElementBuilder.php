<?php
/**
 * @link    https://github.com/nnx-framework/form-comparator
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\FormComparator\Comparator\CollectionDiffService;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;


/**
 * Class HashElementBuilder
 *
 * @package Nnx\FormComparator\Comparator\CollectionDiffService
 */
class HashElementBuilder
{

    /**
     * Набор данных из которых строится хеш
     *
     * @var array
     */
    private $hashParts = [];


    /**
     * @param ElementInterface $element
     *
     * @return string
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    public function hash(ElementInterface $element)
    {
        $this->hashParts = [];

        $this->buildHash($element);

        ksort($this->hashParts, SORT_STRING);


        $hashStack = [];
        foreach ($this->hashParts as $key => $value) {
            $hashStack[] = $key . '=' . $value;
        }

        return implode('|', $hashStack);
    }


    /**
     * @param ElementInterface $element
     * @param null|string      $namePrefix
     *
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    protected function buildHash(ElementInterface $element, $namePrefix = null)
    {
        if (null === $namePrefix) {
            $elementName = $element->getName();
        } else {
            $elementName = $namePrefix . '.' . $element->getName();
        }
        if ($element instanceof FieldsetInterface) {
            foreach ($element->getIterator() as $childElementOrFieldset) {
                $this->buildHash($childElementOrFieldset, $elementName);
            }
        } else {
            $this->hashParts[$elementName] = $this->normalizeValue($element->getValue());
        }
    }

    /**
     * Представлет значение элемента формы в виде строки
     *
     * @param $rawValue
     *
     * @return string
     * @throws \Nnx\FormComparator\Comparator\CollectionDiffService\Exception\RuntimeException
     */
    protected function normalizeValue($rawValue)
    {

        if ($rawValue instanceof \DateTimeInterface) {
            $value = (string)$rawValue->getTimestamp();
        } else {
            $value = $rawValue;
            $resultConvert = @settype($value, 'string');
            if (false === $resultConvert) {
                throw new Exception\RuntimeException('Invalid type convert');
            }
        }

        return $value;
    }


}
