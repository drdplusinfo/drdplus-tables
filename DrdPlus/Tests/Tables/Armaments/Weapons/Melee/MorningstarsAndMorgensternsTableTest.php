<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\MorningstarsAndMorgensternsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class MorningstarsAndMorgensternsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::REQUIRED_STRENGTH, 3],
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::LENGTH, 2],
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::WOUNDS, 3],
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::LIGHT_MORGENSTERN, MeleeWeaponsTable::WEIGHT, 2.0],

            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::REQUIRED_STRENGTH, 7],
            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::WOUNDS, 6],
            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::MORGENSTERN, MeleeWeaponsTable::WEIGHT, 2.5],

            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::REQUIRED_STRENGTH, 11],
            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::WOUNDS, 9],
            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::HEAVY_MORGENSTERN, MeleeWeaponsTable::WEIGHT, 3.0],

            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::REQUIRED_STRENGTH, 2],
            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::WOUNDS, 4],
            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::FLAIL, MeleeWeaponsTable::WEIGHT, 2.0],

            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::REQUIRED_STRENGTH, 6],
            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::WOUNDS, 8],
            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::MORNINGSTAR, MeleeWeaponsTable::WEIGHT, 3.0],

            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::REQUIRED_STRENGTH, 7],
            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::WOUNDS, 10],
            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::HOBNAILED_FLAIL, MeleeWeaponsTable::WEIGHT, 4.0],

            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::REQUIRED_STRENGTH, 11],
            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::WOUNDS, 13],
            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::HEAVY_MORNINGSTAR, MeleeWeaponsTable::WEIGHT, 5.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $morningstarsAndMorgensternsTable = new MorningstarsAndMorgensternsTable();
        foreach (MeleeWeaponCode::getMorningstarAndMorgensternCodes() as $morningstarAndMorgensternCode) {
            $row = $morningstarsAndMorgensternsTable->getRow([$morningstarAndMorgensternCode]);
            self::assertNotEmpty($row);
        }
    }

}