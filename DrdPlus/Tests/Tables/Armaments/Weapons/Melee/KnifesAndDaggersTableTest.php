<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\MeleeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\KnifesAndDaggersTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class KnifesAndDaggersTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::REQUIRED_STRENGTH, -3],
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::OFFENSIVENESS, 0],
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::WOUNDS, -2],
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::COVER, 1],
            [MeleeWeaponCode::KNIFE, MeleeWeaponsTable::WEIGHT, 0.2],

            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::REQUIRED_STRENGTH, -1],
            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::OFFENSIVENESS, 1],
            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::WOUNDS, 1],
            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::DAGGER, MeleeWeaponsTable::WEIGHT, 0.2],

            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::REQUIRED_STRENGTH, -1],
            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::WOUNDS, 0],
            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::COVER, 1],
            [MeleeWeaponCode::STABBING_DAGGER, MeleeWeaponsTable::WEIGHT, 0.2],

            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::REQUIRED_STRENGTH, -2],
            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::LENGTH, 1],
            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::OFFENSIVENESS, 1],
            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::WOUNDS, -1],
            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::COVER, 1],
            [MeleeWeaponCode::LONG_KNIFE, MeleeWeaponsTable::WEIGHT, 0.2],

            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::REQUIRED_STRENGTH, 1],
            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::LENGTH, 1],
            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::OFFENSIVENESS, 1],
            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::WOUNDS, 2],
            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::COVER, 2],
            [MeleeWeaponCode::LONG_DAGGER, MeleeWeaponsTable::WEIGHT, 0.3],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $knifesAndDaggersTable = new KnifesAndDaggersTable();
        foreach (MeleeWeaponCode::getKnifeAndDaggerCodes() as $knifeAndDaggerCode) {
            $row = $knifesAndDaggersTable->getRow([$knifeAndDaggerCode]);
            self::assertNotEmpty($row);
        }
    }

}