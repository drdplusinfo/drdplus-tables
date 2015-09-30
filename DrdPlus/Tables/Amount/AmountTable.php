<?php
namespace DrdPlus\Tables\Amount;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Tables\Parts\AbstractFileTable;
use DrdPlus\Tables\Tools\DiceChanceEvaluator;

/**
 * PPH page 164, top
 *
 * @method AmountBonus toBonus(Amount $amount)
 */
class AmountTable extends AbstractFileTable
{
    public function __construct()
    {
        parent::__construct(new DiceChanceEvaluator(new Roll1d6()));
    }

    protected function getDataFileName()
    {
        return __DIR__ . '/data/amount.csv';
    }

    protected function getExpectedDataHeader()
    {
        return [Amount::AMOUNT];
    }

    /**
     * @param AmountBonus $bonus
     *
     * @return Amount
     */
    public function toAmount(AmountBonus $bonus)
    {
        return $this->toMeasurement($bonus);
    }

    /**
     * @param float $value
     * @param string $unit
     *
     * @return Amount
     */
    protected function convertToMeasurement($value, $unit)
    {
        $this->checkUnit($unit);

        return new Amount($value, Amount::AMOUNT, $this);
    }

    /**
     * @param $bonusValue
     *
     * @return AmountBonus
     */
    protected function createBonus($bonusValue)
    {
        return new AmountBonus($bonusValue, $this);
    }

}
