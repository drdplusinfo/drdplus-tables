<?php
namespace DrdPlus\Tables\Body\Jumping;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Calculations\SumAndRound;
use DrdPlus\Codes\Environment\LandingSurfaceCode;
use DrdPlus\Codes\JumpMovementCode;
use DrdPlus\Codes\JumpTypeCode;
use DrdPlus\Properties\Base\Agility;
use DrdPlus\Properties\Body\Weight;
use DrdPlus\Properties\Derived\Athletics;
use DrdPlus\Properties\Derived\Speed;
use DrdPlus\Tables\Environments\LandingSurfacesTable;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Measurements\Wounds\WoundsBonus;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Integer\PositiveInteger;

/**
 * See PPH page 119 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_skoku
 */
class JumpsAndFallsTable extends AbstractFileTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/jumps_and_falls.csv';
    }

    /**
     * @return array
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            JumpMovementCode::STANDING_JUMP => self::INTEGER,
            JumpMovementCode::FLYING_JUMP => self::INTEGER,
        ];
    }

    const JUMP_TYPE = 'jump_type';

    /**
     * @return array
     */
    protected function getRowsHeader()
    {
        return [
            self::JUMP_TYPE,
        ];
    }

    /**
     * @param JumpTypeCode $jumpTypeCode
     * @param JumpMovementCode $jumpMovementCode
     * @return int
     */
    public function getModifierToJump(JumpTypeCode $jumpTypeCode, JumpMovementCode $jumpMovementCode)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue($jumpTypeCode, $jumpMovementCode);
    }

    /**
     * @param Speed $speed
     * @param Athletics $athletics
     * @param JumpTypeCode $jumpTypeCode
     * @param JumpMovementCode $jumpMovementCode
     * @param Roll1d6 $roll1D6
     * @return int
     */
    public function getJumpLength(
        Speed $speed,
        Athletics $athletics,
        JumpTypeCode $jumpTypeCode,
        JumpMovementCode $jumpMovementCode,
        Roll1d6 $roll1D6
    )
    {
        return $this->getModifierToJump($jumpTypeCode, $jumpMovementCode)
            + SumAndRound::half($speed->getValue())
            + $athletics->getAthleticsBonus()->getValue()
            + $roll1D6->getValue();
    }

    /**
     * @param Distance $distance
     * @param Weight $bodyWeight
     * @param Roll1d6 $roll1D6
     * @param bool $itIsControlledJump
     * @param Agility $agility
     * @param WoundsTable $woundsTable
     * @param LandingSurfaceCode $landingSurfaceCode
     * @param PositiveInteger $armorProtection
     * @param LandingSurfacesTable $landingSurfacesTable
     * @return Wounds
     */
    public function getWoundsFromJumpOrFall(
        Distance $distance,
        Weight $bodyWeight,
        Roll1d6 $roll1D6,
        $itIsControlledJump,
        Agility $agility,
        LandingSurfaceCode $landingSurfaceCode,
        PositiveInteger $armorProtection,
        WoundsTable $woundsTable,
        LandingSurfacesTable $landingSurfacesTable
    )
    {
        $meters = $distance->getMeters();
        if ($itIsControlledJump) {
            $meters -= 2;
        }
        $powerOfWound = $meters + SumAndRound::half($bodyWeight->getValue()) - 5 + $roll1D6->getValue();
        $powerOfWound += $landingSurfacesTable->getPowerOfWoundModifier($landingSurfaceCode, $agility, $armorProtection);
        if ($powerOfWound < 0) {
            $powerOfWound = 0;
        }
        $convertedPowerOfWounds = (new WoundsBonus($powerOfWound, $woundsTable))->getWounds()->getValue();
        $convertedAgility = (new WoundsBonus($agility->getValue(), $woundsTable))->getWounds()->getValue();
        $woundsValue = $convertedPowerOfWounds - $convertedAgility;
        if ($woundsValue < 0) {
            $woundsValue = 0;
        }

        return new Wounds($woundsValue, $woundsTable);
    }
}