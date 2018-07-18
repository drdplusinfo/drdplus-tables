<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Combat;

use DrdPlus\Tables\Combat\CombatCharacteristicsTable;
use DrdPlus\Tests\Tables\TableTest;

class CombatCharacteristicsTableTest extends TableTest
{
    /**
     * @test
     */
    public function I_can_get_header(): void
    {
        self::assertSame(
            [['characteristic', 'property', 'divide_by', 'round_up', 'round_down']],
            (new CombatCharacteristicsTable())->getHeader()
        );
    }
}