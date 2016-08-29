<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Partials\AbstractMeleeWeaponlikeSanctionsByMissingStrengthTable;

/**
 * Shield uses same sanctions as a weapon
 */
class ShieldSanctionsByMissingStrengthTable extends AbstractMeleeWeaponlikeSanctionsByMissingStrengthTable
{
    /**
     * @param $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseShield($missingStrength)
    {
        return $this->canUseArmament($missingStrength);
    }

    /**
     * Because shield can be used as a weapon and therefore shares same interface
     * @param $missingStrength
     * @return bool
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function canUseWeapon($missingStrength)
    {
        return $this->canUseArmament($missingStrength);
    }
}