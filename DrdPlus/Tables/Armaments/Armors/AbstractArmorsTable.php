<?php
namespace DrdPlus\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Partials\UnwieldyParametersInterface;
use DrdPlus\Tables\Partials\AbstractFileTable;
use Granam\Tools\ValueDescriber;

abstract class AbstractArmorsTable extends AbstractFileTable implements UnwieldyParametersInterface
{

    const PROTECTION_HEADER = 'protection';

    protected function getExpectedDataHeader()
    {
        return [
            self::REQUIRED_STRENGTH_HEADER => self::INTEGER,
            self::RESTRICTION_HEADER => self::INTEGER,
            self::PROTECTION_HEADER => self::INTEGER,
            self::WEIGHT_HEADER => self::FLOAT,
        ];
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getRequiredStrengthOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::REQUIRED_STRENGTH_HEADER);
    }

    /**
     * @param string $armorCode
     * @param $valueName
     * @return bool|float|int|string
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    private function getValueFor($armorCode, $valueName)
    {
        try {
            return $this->getValue([$armorCode], $valueName);
        } catch (\DrdPlus\Tables\Partials\Exceptions\RequiredRowDataNotFound $exception) {
            throw new Exceptions\UnknownArmorCode(
                'Unknown armor code ' . ValueDescriber::describe($armorCode)
            );
        }
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getRestrictionOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::RESTRICTION_HEADER);
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getProtectionOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::PROTECTION_HEADER);
    }

    /**
     * @param string $armorCode
     * @return int|false
     * @throws \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function getWeightOf($armorCode)
    {
        return $this->getValueFor($armorCode, self::WEIGHT_HEADER);
    }
}