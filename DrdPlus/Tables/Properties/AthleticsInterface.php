<?php
declare(strict_types=1);
/** be strict for parameter types, https://www.quora.com/Are-strict_types-in-PHP-7-not-a-bad-idea */
namespace DrdPlus\Tables\Properties;

use Granam\Integer\IntegerInterface;
use Granam\Integer\PositiveInteger;

/**
 * Just an interface to cover requirements. It is not implemented in this library.
 */
interface AthleticsInterface extends IntegerInterface
{
    /**
     * @return PositiveInteger
     */
    public function getAthleticsBonus(): PositiveInteger;
}