<?php
namespace DrdPlus\Tables\Professions;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;

class BackgroundSkillsTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideSkillPointToProfession
     * @param int $backgroundSkillPoints
     * @param string $professionCode
     * @param string $skillGroup
     * @param int $expectedSkillPoints
     */
    public function I_can_get_skills_for_each_profession(
        $backgroundSkillPoints,
        $professionCode,
        $skillGroup,
        $expectedSkillPoints
    )
    {
        $table = new BackgroundSkillsTable();
        $skillPoints = $table->getSkillPoints($backgroundSkillPoints, $professionCode, $skillGroup);
        $this->assertSame($expectedSkillPoints, $skillPoints);

        $getGroupSkillPoints = 'get' . ucfirst($skillGroup) . 'SkillPoints';
        $groupSkillPoints = $table->$getGroupSkillPoints($backgroundSkillPoints, $professionCode);
        $this->assertSame($expectedSkillPoints, $groupSkillPoints);

        $getProfessionGroupSkillPoints = 'get' . ucfirst($professionCode) . ucfirst($skillGroup) . 'SkillPoints';
        $professionGroupSkillPoints = $table->$getProfessionGroupSkillPoints($backgroundSkillPoints);
        $this->assertSame($expectedSkillPoints, $professionGroupSkillPoints);
    }

    public function provideSkillPointToProfession()
    {
        $combinations = [];
        $rowIndex = 0;
        for ($backgroundSkillPoint = 0; $backgroundSkillPoint <= 8; $backgroundSkillPoint++) {
            $columnIndex = 0;
            foreach (ProfessionCodes::getProfessionCodes() as $professionCode) {
                foreach (SkillCodes::getSkillTypes() as $type) {
                    $combinations[] = [
                        $backgroundSkillPoint,
                        $professionCode,
                        $type,
                        $this->getExpectedSkillPoints($rowIndex, $columnIndex)
                    ];
                    $columnIndex++;
                }
            }
            $rowIndex++;
        }

        return $combinations;
    }

    private $expectedSkillPoints = [
        [2, 0, 1, 0, 3, 0, 0, 1, 2, 0, 2, 1, 2, 0, 1, 1, 1, 1],
        [3, 0, 1, 1, 3, 0, 0, 2, 2, 0, 3, 1, 2, 0, 2, 2, 1, 1],
        [4, 0, 1, 1, 4, 0, 1, 2, 2, 0, 4, 1, 3, 0, 2, 2, 1, 2],
        [4, 1, 2, 2, 4, 1, 1, 3, 3, 1, 4, 2, 3, 1, 3, 3, 2, 2],
        [5, 1, 3, 2, 5, 2, 2, 3, 4, 1, 5, 3, 4, 1, 4, 4, 2, 3],
        [6, 2, 3, 3, 6, 2, 2, 4, 5, 2, 6, 3, 5, 1, 5, 5, 2, 4],
        [8, 2, 4, 4, 7, 3, 3, 5, 6, 2, 8, 4, 6, 2, 6, 6, 3, 5],
        [10, 3, 5, 5, 9, 4, 4, 7, 7, 3, 10, 5, 8, 3, 7, 8, 4, 6],
        [12, 4, 6, 6, 11, 5, 5, 9, 8, 4, 12, 6, 10, 4, 8, 9, 6, 7]
    ];

    private function getExpectedSkillPoints($rowIndex, $columnIndex)
    {
        return $this->expectedSkillPoints[$rowIndex][$columnIndex];
    }

}
