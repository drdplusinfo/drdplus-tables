<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Integer\Tools\ToInteger;

/**
 * @method int getValue()
 * @see Fatigue::normalizeValue()
 */
class Fatigue extends AbstractMeasurementWithBonus
{
    public const FATIGUE = 'fatigue';

    /**
     * @var FatigueTable
     */
    private $fatigueTable;

    /**
     * @param float|int|\Granam\Number\NumberInterface $value
     * @param FatigueTable $fatigueTable
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function __construct($value, FatigueTable $fatigueTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct($value, self::FATIGUE);
        $this->fatigueTable = $fatigueTable;
    }

    /**
     * @param mixed $value
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    protected function normalizeValue($value): int
    {
        return ToInteger::toInteger($value);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits(): array
    {
        return [self::FATIGUE];
    }

    /**
     * @return FatigueBonus
     */
    public function getBonus(): FatigueBonus
    {
        return $this->fatigueTable->toBonus($this);
    }

}