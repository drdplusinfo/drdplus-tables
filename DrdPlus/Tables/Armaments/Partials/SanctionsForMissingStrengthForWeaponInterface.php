<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface SanctionsForMissingStrengthForWeaponInterface
{
    /**
     * @param int $missingStrength
     * @return bool
     */
    public function canUseWeapon($missingStrength);

    /**
     * @param int $missingStrength
     * @return int
     */
    public function getAttackNumberSanction($missingStrength);

    /**
     * @param int $missingStrength
     * @return bool
     */
    public function getBaseOfWoundsSanction($missingStrength);

    /**
     * @param int $missingStrength
     * @return bool
     */
    public function getFightNumberSanction($missingStrength);
}