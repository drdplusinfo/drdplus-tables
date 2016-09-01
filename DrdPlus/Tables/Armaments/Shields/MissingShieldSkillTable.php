<?php
namespace DrdPlus\Tables\Armaments\Shields;

use DrdPlus\Tables\Armaments\Partials\AbstractMissingArmamentSkillTable;
use Granam\Integer\IntegerInterface;

class MissingShieldSkillTable extends AbstractMissingArmamentSkillTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/missing_shield_skill.csv';
    }

    const RESTRICTION_BONUS = 'restriction_bonus';
    const COVER = 'cover';

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::RESTRICTION_BONUS => self::POSITIVE_INTEGER,
            self::COVER => self::NEGATIVE_INTEGER
        ];
    }

    /**
     * @param int|IntegerInterface $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getRestrictionBonusForSkill($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::RESTRICTION_BONUS);
    }

    /**
     * @param int|IntegerInterface $skillRank
     * @return int
     * @throws \DrdPlus\Tables\Armaments\Partials\Exceptions\UnexpectedSkillRank
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    public function getCoverForSkillRank($skillRank)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueForSkillRank($skillRank, self::COVER);
    }

}