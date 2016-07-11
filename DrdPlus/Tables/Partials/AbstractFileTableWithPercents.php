<?php
namespace DrdPlus\Tables\Partials;

use DrdPlus\Tools\Calculations\SumAndRound;
use Granam\Tools\ValueDescriber;

abstract class AbstractFileTableWithPercents extends AbstractFileTable
{

    const BONUS_FROM = 'bonus_from';
    const BONUS_TO = 'bonus_to';
    const CAN_BE_MORE = 'can_be_more';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::BONUS_FROM => self::INTEGER,
            self::BONUS_TO => self::INTEGER,
            self::CAN_BE_MORE => self::BOOLEAN,
        ];
    }

    /**
     * @param string $code
     * @param Percents $percents
     * @return int
     * @throws \DrdPlus\Tables\Partials\Exceptions\UnexpectedPercents
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    protected function getBonusBy($code, Percents $percents)
    {
        if ($percents->getValue() > 100 && !$this->canBeMore($code)) {
            throw new Exceptions\UnexpectedPercents(
                'For ' . ValueDescriber::describe($code)
                . " can be percents of addition only between zero and one hundred, got {$percents}"
            );
        }
        $bonusFrom = $this->getBonusBorder($code, self::BONUS_FROM);
        $bonusTo = $this->getBonusBorder($code, self::BONUS_TO);
        if ($bonusFrom < $bonusTo) { // has to swap start and end
            list($bonusFrom, $bonusTo) = [$bonusTo, $bonusFrom];
        }
        $difference = $bonusTo - $bonusFrom;
        $addition = $difference * $percents->getRate();
        $totalBonus = $bonusFrom + $addition;

        return SumAndRound::round($totalBonus);
    }

    private function canBeMore($conditionsCode)
    {
        return $this->getValue([$conditionsCode], self::CAN_BE_MORE);
    }

    /**
     * @param string $code
     * @param string $bonusBorderType
     * @return mixed
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     * @throws \DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound
     */
    private function getBonusBorder($code, $bonusBorderType)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValue([$code], $bonusBorderType);
    }
}