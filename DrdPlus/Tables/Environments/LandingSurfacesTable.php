<?php
namespace DrdPlus\Tables\Environments;

use DrdPlus\Calculations\SumAndRound;
use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\PositiveInteger;

/**
 * See PPH page 119 right column, @link https://pph.drdplus.info/#tabulka_povrchu
 */
class LandingSurfacesTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/landing_surfaces.csv';
    }

    const POWER_OF_WOUND_MODIFIER = 'power_of_wound_modifier';
    const AGILITY_MULTIPLIER_PROTECTION = 'agility_multiplier_protection';
    const ARMOR_MAX_PROTECTION = 'armor_max_protection';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes(): array
    {
        return [
            self::POWER_OF_WOUND_MODIFIER => self::INTEGER,
            self::AGILITY_MULTIPLIER_PROTECTION => self::POSITIVE_INTEGER,
            self::ARMOR_MAX_PROTECTION => self::POSITIVE_INTEGER,
        ];
    }

    const SURFACE = 'surface';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::SURFACE];
    }

    /**
     * @param LandingSurfaceCode $landingSurfaceCode
     * @param Agility $agility
     * @param PositiveInteger $armorProtection
     * @return int
     */
    public function getWoundsModifier(
        LandingSurfaceCode $landingSurfaceCode,
        Agility $agility,
        PositiveInteger $armorProtection
    ): int
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $row = $this->getRow($landingSurfaceCode);
        $powerOfWoundModifier = $row[self::POWER_OF_WOUND_MODIFIER];
        $agilityMultiplierBonus = $row[self::AGILITY_MULTIPLIER_PROTECTION];
        if ($agilityMultiplierBonus && $agility->getValue() > 0) {
            $powerOfWoundModifier -= $agilityMultiplierBonus * $agility->getValue();
        } else {
            // third of negative agility is used - and yes, it INCREASES wounds (minus minus = plus)
            $powerOfWoundModifier -= SumAndRound::round($agilityMultiplierBonus * $agility->getValue() / 3);
        }
        $armorMaxProtection = $row[self::ARMOR_MAX_PROTECTION];
        if ($armorMaxProtection) {
            if ($armorProtection->getValue() > $armorMaxProtection) {
                $powerOfWoundModifier -= $armorMaxProtection;
            } else {
                $powerOfWoundModifier -= $armorProtection->getValue();
            }
        }

        return $powerOfWoundModifier;
    }

}