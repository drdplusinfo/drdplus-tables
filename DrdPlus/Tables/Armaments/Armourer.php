<?php
namespace DrdPlus\Tables\Armaments;

use DrdPlus\Codes\Armaments\ArmamentCode;
use DrdPlus\Codes\Armaments\ArmorCode;
use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\Armaments\MeleeWeaponlikeCode;
use DrdPlus\Codes\Armaments\ProtectiveArmamentCode;
use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Armaments\ShieldCode;
use DrdPlus\Codes\Armaments\WeaponlikeCode;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Body\Size;
use DrdPlus\Properties\Combat\EncounterRange;
use DrdPlus\Properties\Combat\MaximalRange;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Armaments\Exceptions\CanNotUseArmorBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownArmament;
use DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike;
use DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon;
use DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength;
use DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Exceptions\UnknownBow;
use DrdPlus\Tables\Environments\Exceptions\DistanceOutOfKnownValues;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Tables;
use DrdPlus\Tools\Calculations\SumAndRound;
use Granam\Integer\PositiveInteger;
use Granam\Strict\Object\StrictObject;

class Armourer extends StrictObject
{
    /**
     * @var Tables
     */
    private $tables;

    public function __construct(Tables $tables)
    {
        $this->tables = $tables;
    }

    // WEAPONS ONLY

    /**
     * @param ArmamentCode $armamentCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getRequiredStrengthForArmament(ArmamentCode $armamentCode)
    {
        return $this->tables->getArmamentsTableByArmamentCode($armamentCode)->getRequiredStrengthOf($armamentCode);
    }

    /**
     * Increases fight number.
     * Note about shield: every shield is considered as a weapon of length 0 if used for attack.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownMeleeWeaponlike
     */
    public function getLengthOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        if ($weaponlikeCode instanceof MeleeWeaponlikeCode) {
            return $this->tables->getMeleeWeaponlikeTableByMeleeWeaponlikeCode($weaponlikeCode)
                ->getLengthOf($weaponlikeCode);
        }

        return 0; // ranged weapons do not have bonus to fight number for their length, surprisingly
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownWeaponlike
     */
    public function getWoundsOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getWoundsOf($weaponlikeCode);
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function getWoundsTypeOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getWoundsTypeOf($weaponlikeCode);
    }

    /**
     * Note about shield: shield is always used as a shield for cover, even if is used for desperate attack.
     *
     * @param WeaponlikeCode $weaponOrShield
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     */
    public function getCoverOfWeaponOrShield(WeaponlikeCode $weaponOrShield)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponOrShield)->getCoverOf($weaponOrShield);
    }

    /**
     * Even shield can be used as weapon, just quite ineffective.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return int
     * @throws Exceptions\UnknownWeaponlike
     */
    public function getOffensivenessOfWeaponlike(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getOffensivenessOf($weaponlikeCode);
    }

    /**
     * @param ArmamentCode $armamentCode
     * @return int
     * @throws Exceptions\UnknownArmament
     */
    public function getWeightOfArmament(ArmamentCode $armamentCode)
    {
        return $this->tables->getArmamentsTableByArmamentCode($armamentCode)->getWeightOf($armamentCode);
    }

    /**
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function isTwoHandedOnly(WeaponlikeCode $weaponlikeCode)
    {
        return $this->tables->getWeaponlikeTableByWeaponlikeCode($weaponlikeCode)->getTwoHandedOf($weaponlikeCode);
    }

    /**
     * There are weapons so small so can not be hold by two hands
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function isOneHandedOnly(WeaponlikeCode $weaponlikeCode)
    {
        return !$this->canHoldItByTwoHands($weaponlikeCode);
    }

    /**
     * Not all weapons can be hold by two hands - some of them are simply so small so it is not possible or highly
     * ineffective.
     *
     * @param WeaponlikeCode $weaponToHoldByTwoHands
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function canHoldItByTwoHands(WeaponlikeCode $weaponToHoldByTwoHands)
    {
        return
            // shooting weapons are two-handed (except minicrossbow), projectiles are not
            $this->isTwoHandedOnly($weaponToHoldByTwoHands) // the weapon is explicitly two-handed
            // or it is melee weapon with length at least 1 (see PPH page 92 right column)
            || ($weaponToHoldByTwoHands->isMelee() && $this->getLengthOfWeaponlike($weaponToHoldByTwoHands) >= 1);
    }

    /**
     * Some weapons are so specific so keeping them in a single hand would make them highly inefficient, like a halberd.
     *
     * @param WeaponlikeCode $weaponToHoldByTwoHands
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function canHoldItByOneHand(WeaponlikeCode $weaponToHoldByTwoHands)
    {
        return !$this->isTwoHandedOnly($weaponToHoldByTwoHands); // shooting weapons are two-handed (except minicrossbow), projectiles are not
    }

    /**
     * Note about SHIELD: it has always length of 0 and therefore you can NOT hold it by both hands (but the last word
     * has DM).
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     * @throws Exceptions\UnknownWeaponlike
     */
    public function canHoldItByOneHandAsWellAsTwoHands(WeaponlikeCode $weaponlikeCode)
    {
        return
            $this->canHoldItByOneHand($weaponlikeCode)
            && $this->canHoldItByTwoHands($weaponlikeCode);
    }

    /**
     * Even LEG and HOBNAILED BOOT are considered as empty hand.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @return bool
     */
    public function hasEmptyHand(WeaponlikeCode $weaponlikeCode)
    {
        return
            ($weaponlikeCode instanceof ShieldCode && $weaponlikeCode->isWithoutShield())
            || ($weaponlikeCode instanceof MeleeWeaponCode && $weaponlikeCode->isUnarmed());
    }


    // shield-and-armor-specific

    /**
     * Restriction affects fight number (Fight number malus).
     *
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProtectiveArmament
     */
    public function getRestrictionOfProtectiveArmament(ProtectiveArmamentCode $protectiveArmamentCode)
    {
        return $this->tables->getProtectiveArmamentsTable($protectiveArmamentCode)
            ->getRestrictionOf($protectiveArmamentCode);
    }

    // range-weapon-specific

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     */
    public function getRangeOfRangedWeapon(RangedWeaponCode $rangedWeaponCode)
    {
        return $this->tables->getRangedWeaponsTableByRangedWeaponCode($rangedWeaponCode)->getRangeOf($rangedWeaponCode);
    }

    // ARMAMENTS USAGE AFFECTED BY STRENGTH

    /**
     * Gives effective strength usable for attack with given weapon (has usage for bows and crossbows).
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return Strength
     * @throws UnknownBow
     * @throws UnknownRangedWeapon
     */
    public function getApplicableStrength(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        if (!$weaponlikeCode->isShootingWeapon()) {
            return $currentStrength;
        }
        assert($weaponlikeCode instanceof RangedWeaponCode);
        /** @var RangedWeaponCode $weaponlikeCode */
        if ($weaponlikeCode->isBow()) {
            $strengthValue = min(
                $currentStrength->getValue(),
                $this->tables->getBowsTable()->getMaximalApplicableStrengthOf($weaponlikeCode)
            );

            return Strength::getIt($strengthValue);
        }
        assert($weaponlikeCode->isCrossbow());

        // crossbow as a machine does not apply shooter strength, just its own - see PPH page 94 right column
        return Strength::getIt($this->tables->getCrossbowsTable()->getRequiredStrengthOf($weaponlikeCode));
    }

    /**
     * Note: spear can be both range and melee, but required strength is for melee and range usages the same
     *
     * @param ArmamentCode $armamentCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return bool
     * @throws Exceptions\UnknownArmament
     */
    public function canUseArmament(ArmamentCode $armamentCode, Strength $currentStrength, Size $bodySize)
    {
        return $this->tables->getArmamentStrengthSanctionsTableByCode($armamentCode)->canUseIt(
            $this->getMissingStrengthForArmament($armamentCode, $currentStrength, $bodySize)
        );
    }

    /**
     * See PPH page 91, right column
     *
     * @param ArmamentCode $armamentCode
     * @param Size $bodySize
     * @param Strength $currentStrength
     * @return int positive number
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getMissingStrengthForArmament(ArmamentCode $armamentCode, Strength $currentStrength, Size $bodySize)
    {
        $requiredStrength = $this->tables->getArmamentsTableByArmamentCode($armamentCode)->getRequiredStrengthOf($armamentCode);
        $missingStrength = $requiredStrength - $currentStrength->getValue();
        if ($armamentCode instanceof ArmorCode) {
            // only armor weight is related to body size
            $missingStrength += $bodySize->getValue();
        }
        if ($missingStrength < 0) {
            // missing strength can not be negative, of course
            return 0;
        }

        return $missingStrength;
    }

    /**
     * Note about shield: this malus is very same if used shield as a protective item as well as a weapon.
     *
     * @param WeaponlikeCode $weaponOrShield
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownArmament
     * @throws Exceptions\UnknownMeleeWeaponlike
     * @throws Exceptions\UnknownWeaponlike
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getFightNumberMalusByStrengthWithWeaponOrShield(WeaponlikeCode $weaponOrShield, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponOrShield)->getFightNumberSanction(
            $this->getMissingStrengthForArmament($weaponOrShield, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws Exceptions\UnknownWeaponlike
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     */
    public function getAttackNumberMalusByStrengthWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getAttackNumberSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Distance modifier can be solved very roughly by a simple table or more precisely with continual values by a calculation.
     * This uses that calculation.
     * See PPH page 104 left column.
     *
     * @param EncounterRange $currentEncounterRange
     * @param Distance $distance
     * @param MaximalRange $currentMaximalRange
     * @return int
     * @throws Exceptions\DistanceIsOutOfMaximalRange
     * @throws Exceptions\EncounterRangeCanNotBeGreaterThanMaximalRange
     * @throws DistanceOutOfKnownValues
     */
    public function getAttackNumberModifierByDistance(
        Distance $distance,
        EncounterRange $currentEncounterRange,
        MaximalRange $currentMaximalRange
    )
    {
        if ($distance->getBonus()->getValue() > $currentMaximalRange->getValue()) { // comparing distance bonuses in fact
            throw new Exceptions\DistanceIsOutOfMaximalRange(
                "Given distance {$distance->getBonus()} ({$distance->getMeters()} meters)"
                . " is out of maximal range {$currentMaximalRange}"
                . ' ('. $currentMaximalRange->getInMeters($this->tables->getDistanceTable()) . ' meters)'
            );
        }
        if ($currentEncounterRange->getValue() > $currentMaximalRange->getValue()) {
            throw new Exceptions\EncounterRangeCanNotBeGreaterThanMaximalRange(
                "Got encounter range {$currentEncounterRange} greater than given maximal range {$currentMaximalRange}"
            );
        }
        $attackNumberModifier = $this->tables->getContinuousAttackNumberByDistanceTable()
            ->getAttackNumberModifierByDistance($distance);
        if ($distance->getBonus()->getValue() > $currentEncounterRange->getValue()) { // comparing distance bonuses in fact
            $attackNumberModifier += $currentEncounterRange->getValue() - $distance->getBonus()->getValue(); // always negative
        }

        return $attackNumberModifier;
    }

    /**
     * Using ranged weapon for defense is possible (it has always cover of 2) but there is 50% chance it will be
     * destroyed.
     * Note about shield: this malus is very same if used shield as a protective item as well as a weapon.
     *
     * @param WeaponlikeCode $weaponOrShield
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getDefenseNumberMalusByStrengthWithWeaponOrShield(WeaponlikeCode $weaponOrShield, Strength $currentStrength)
    {
        if ($weaponOrShield instanceof RangedWeaponCode && $weaponOrShield->isMelee()) {
            // spear can be used more effectively to cover as a melee weapon
            $weaponOrShield = $weaponOrShield->convertToMeleeWeaponCodeEquivalent();
        }

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponOrShield)->getDefenseNumberSanction(
            $this->getMissingStrengthForArmament($weaponOrShield, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Even shield can ba used as weapon, just quite ineffective.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Weapons\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownWeaponlike
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeaponlike
     */
    public function getBaseOfWoundsMalusByStrengthWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        return $this->tables->getWeaponlikeStrengthSanctionsTableByCode($weaponlikeCode)->getBaseOfWoundsSanction(
            $this->getMissingStrengthForArmament($weaponlikeCode, $currentStrength, Size::getIt(0))
        );
    }

    // range-weapon-specific usage affected by properties

    /**
     * The final number of rounds needed to load a weapon.
     *
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsByStrengthWithRangedWeapon(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponStrengthSanctionsTable()->getLoadingInRounds(
            $this->getMissingStrengthForArmament($rangedWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * The relative number of rounds as a malus to standard number of rounds needed to load a weapon.
     *
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    public function getLoadingInRoundsMalusByStrengthWithRangedWeapon(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponStrengthSanctionsTable()->getLoadingInRoundsSanction(
            $this->getMissingStrengthForArmament($rangedWeaponCode, $currentStrength, Size::getIt(0))
        );
    }

    /**
     * Gives bonus to range of a weapon, which can be turned into meters.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @param Speed $currentSpeed
     * @return EncounterRange
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownArmament
     * @throws UnknownRangedWeapon
     * @throws UnknownBow
     */
    public function getEncounterRangeWithWeaponlike(
        WeaponlikeCode $weaponlikeCode,
        Strength $currentStrength,
        Speed $currentSpeed
    )
    {
        if (!($weaponlikeCode instanceof RangedWeaponCode)) {
            /** note: melee weapon length in meters is half of weapon length, see PPH page 85 right column */
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return new EncounterRange(0);
        }
        $encounterRange = $this->getRangeOfRangedWeapon($weaponlikeCode);
        $encounterRange += $this->getEncounterRangeMalusByStrength($weaponlikeCode, $currentStrength);
        $encounterRange += $this->getEncounterRangeBonusByStrength($weaponlikeCode, $currentStrength);
        $encounterRange += $this->getEncounterRangeBonusBySpeed($weaponlikeCode, $currentSpeed);

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new EncounterRange($encounterRange);
    }

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownArmament
     * @throws UnknownBow
     */
    private function getEncounterRangeMalusByStrength(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        if (!$rangedWeaponCode->isBow() && !$rangedWeaponCode->isThrowingWeapon()) {
            return 0;
        }
        $missingStrength = $this->getMissingStrengthForArmament(
            $rangedWeaponCode,
            $currentStrength,
            Size::getIt(0) // size is irrelevant for this armament
        );

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getRangedWeaponStrengthSanctionsTable()->getEncounterRangeSanction(
            $missingStrength
        );
    }

    /**
     * Bows get bonus to range from used strength (up to maximal strength applicable for given bow).
     * Other ranged weapons gets no range bonus (zero) from strength.
     *
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownBow
     * @throws UnknownRangedWeapon
     */
    private function getEncounterRangeBonusByStrength(RangedWeaponCode $rangedWeaponCode, Strength $currentStrength)
    {
        if (!$rangedWeaponCode->isBow()) {
            return 0;
        }
        $currentStrength = $this->getApplicableStrength($rangedWeaponCode, $currentStrength);

        // the range bonus for bow is equal to strength applicable for it
        return min(
            $this->tables->getBowsTable()->getMaximalApplicableStrengthOf($rangedWeaponCode),
            $currentStrength->getValue()
        );
    }

    /**
     * @param RangedWeaponCode $rangedWeaponCode
     * @param Speed $speed
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     */
    private function getEncounterRangeBonusBySpeed(RangedWeaponCode $rangedWeaponCode, Speed $speed)
    {
        if (!$rangedWeaponCode->isThrowingWeapon()) {
            return 0;
        }

        return SumAndRound::half($speed->getValue());
    }

    /**
     * Ranged weapons can be used for indirect shooting and those have much longer maximal and still somehow
     * controllable
     * (more or less - depends on weapon) range.
     * Others have their maximal (and still controllable) range same as encounter range.
     * See PPH page 104 left column.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @param Speed $currentSpeed
     * @return MaximalRange
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws UnknownArmament
     * @throws UnknownRangedWeapon
     * @throws UnknownBow
     */
    public function getMaximalRangeWithWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength, Speed $currentSpeed)
    {
        $encounterRange = $this->getEncounterRangeWithWeaponlike($weaponlikeCode, $currentStrength, $currentSpeed);
        if ($weaponlikeCode->isMelee()) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            return MaximalRange::createForMeleeWeapon($encounterRange); // that is without change and that is zero
        }

        assert($weaponlikeCode->isRanged());

        return MaximalRange::createForRangedWeapon($encounterRange);
    }

    // armor-specific usage affected by strength

    /**
     * @param ArmorCode $armorCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     */
    public function getAgilityMalusByStrengthWithArmor(ArmorCode $armorCode, Strength $currentStrength, Size $bodySize)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getArmorStrengthSanctionsTable()->getAgilityMalus(
            $this->getMissingStrengthForArmament($armorCode, $currentStrength, $bodySize)
        );
    }

    /**
     * @param ArmorCode $armorCode
     * @param Strength $currentStrength
     * @param Size $bodySize
     * @return int
     * @throws CanNotUseArmorBecauseOfMissingStrength
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownArmament
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getSanctionDescriptionByStrengthWithArmor(ArmorCode $armorCode, Strength $currentStrength, Size $bodySize)
    {
        return $this->tables->getArmorStrengthSanctionsTable()->getSanctionDescription(
            $this->getMissingStrengthForArmament($armorCode, $currentStrength, $bodySize)
        );
    }

    // MISSING WEAPON SKILL

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getFightNumberMalusForSkillRank(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getFightNumberMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getAttackNumberMalusForSkillRank(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getAttackNumberMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    /**
     * Gives malus to cover with a weapon or a shield according to given skill rank.
     * Warning: PPH gives you invalid info about cover with shield malus on PPH page 86 right column (-2 if you do not
     * have maximal skill). Correct is @see \DrdPlus\Tables\Armaments\Shields\MissingShieldSkillTable
     * Note about shield: shield is always used as a shield for cover, even if is used for desperate attack.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @param WeaponlikeCode $weaponOrShield
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getCoverMalusForSkillRank(PositiveInteger $weaponTypeSkillRank, WeaponlikeCode $weaponOrShield)
    {
        if ($weaponOrShield->isWeapon()) {
            return $this->tables->getMissingWeaponSkillTable()->getCoverMalusForSkillRank($weaponTypeSkillRank->getValue());
        }
        assert($weaponOrShield->isShield());

        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getMissingShieldSkillTable()->getCoverMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    /**
     * Note about shields: there is no such skill as FightWithShields, any attempt to fight with shield results into
     * zero skill rank.
     *
     * @param PositiveInteger $weaponTypeSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getBaseOfWoundsMalusForSkillRank(PositiveInteger $weaponTypeSkillRank)
    {
        return $this->tables->getMissingWeaponSkillTable()->getBaseOfWoundsMalusForSkillRank($weaponTypeSkillRank->getValue());
    }

    // missing shield-specific skill

    /**
     * Applicable to lower shield or armor Restriction (Fight number malus), but can not make it positive.
     *
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @param PositiveInteger $protectiveArmamentSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     */
    public function getProtectiveArmamentRestrictionBonusForSkillRank(
        ProtectiveArmamentCode $protectiveArmamentCode,
        PositiveInteger $protectiveArmamentSkillRank
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->tables->getProtectiveArmamentMissingSkillTableByCode($protectiveArmamentCode)
            ->getRestrictionBonusForSkillRank($protectiveArmamentSkillRank->getValue());
    }

    /**
     * Restriction is Fight number malus.
     *
     * @param ProtectiveArmamentCode $protectiveArmamentCode
     * @param PositiveInteger $protectiveArmamentSkillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \DrdPlus\Tables\Armaments\Exceptions\UnknownProtectiveArmament
     */
    public function getProtectiveArmamentRestrictionForSkillRank(
        ProtectiveArmamentCode $protectiveArmamentCode,
        PositiveInteger $protectiveArmamentSkillRank
    )
    {
        $restriction = $this->getRestrictionOfProtectiveArmament($protectiveArmamentCode)
            + $this->getProtectiveArmamentRestrictionBonusForSkillRank($protectiveArmamentCode, $protectiveArmamentSkillRank);
        if ($restriction > 0) {
            return 0; // can not turn into bonus
        }

        return $restriction;
    }

    // summations

    /**
     * Gives base of wound with a weapon and user strength.
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param Strength $currentStrength
     * @return int
     * @throws CanNotUseWeaponBecauseOfMissingStrength
     * @throws Exceptions\UnknownArmament
     * @throws Exceptions\UnknownWeaponlike
     * @throws Exceptions\UnknownRangedWeapon
     * @throws UnknownMeleeWeaponlike
     * @throws UnknownBow
     */
    public function getBaseOfWoundsUsingWeaponlike(WeaponlikeCode $weaponlikeCode, Strength $currentStrength)
    {
        // weapon base of wounds has to be summed with strength via bonus summing, see PPH page 92 right column
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $baseOfWounds = $this->tables->getBaseOfWoundsTable()->calculateBaseOfWounds(
            $this->getWoundsOfWeaponlike($weaponlikeCode),
            $this->getApplicableStrength($weaponlikeCode, $currentStrength)
        );
        $baseOfWounds += $this->getBaseOfWoundsMalusByStrengthWithWeaponlike($weaponlikeCode, $currentStrength);

        return $baseOfWounds;
    }

    /**
     * Melee weapon holdable by a single hand but holt by two hands gives more damage (+2).
     * PPH page 92 right column
     *
     * @param WeaponlikeCode $weaponlikeCode
     * @param bool $holdsWeaponByTwoHands
     * @return int
     * @throws Exceptions\CanNotHoldWeaponByTwoHands
     * @throws Exceptions\UnknownWeaponlike
     */
    public function getBaseOfWoundsBonusForHolding(WeaponlikeCode $weaponlikeCode, $holdsWeaponByTwoHands)
    {
        if (!$holdsWeaponByTwoHands) {
            return 0;
        }

        if (!$this->canHoldItByTwoHands($weaponlikeCode)) {
            throw new Exceptions\CanNotHoldWeaponByTwoHands(
                'To get base of wounds bonus for two-hands holding you have to use appropriate weapon'
                . ", got '{$weaponlikeCode}'"
            );
        }
        if (!$weaponlikeCode->isMelee()) {
            return 0;
        }
        if (!$this->canHoldItByOneHandAsWellAsTwoHands($weaponlikeCode)) {
            return 0;
        }

        return 2;
    }

}