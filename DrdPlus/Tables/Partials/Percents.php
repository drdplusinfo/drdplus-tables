<?php
namespace DrdPlus\Tables\Partials;

use Granam\Integer\IntegerInterface;
use Granam\Integer\Tools\ToInteger;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;
use \Granam\Integer\Tools\Exceptions\Exception as ToIntegerException;

abstract class Percents extends StrictObject implements IntegerInterface
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param mixed $value
     * @throws \DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents
     */
    public function __construct($value)
    {
        try {
            $value = ToInteger::toInteger($value);
        } catch (ToIntegerException $toIntegerException) {
            throw new Exceptions\UnexpectedPercents(
                'Invalid percent value ' . $toIntegerException->getMessage()
            );
        }
        if ($value < 0) {
            throw new Exceptions\UnexpectedPercents(
                'Percents can be from zero to one hundred, got ' . ValueDescriber::describe($value)
            );
        }
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return (float)$this->getValue() / 100; // converting always to float because 0 / 100 is integer 0
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue() . ' %';
    }

}