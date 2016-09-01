<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\StaffsAndSpearsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class StaffsAndSpearsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::REQUIRED_STRENGTH, 1],
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::WOUNDS, 2],
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::LIGHT_SPEAR, MeleeWeaponsTable::WEIGHT, 1.0],

            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::REQUIRED_STRENGTH, -4],
            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::OFFENSIVENESS, 1],
            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::WOUNDS, -1],
            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::SHORTENED_STAFF, MeleeWeaponsTable::WEIGHT, 0.3],

            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::REQUIRED_STRENGTH, -1],
            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::WOUNDS, 0],
            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::LIGHT_STAFF, MeleeWeaponsTable::WEIGHT, 0.5],

            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::REQUIRED_STRENGTH, 3],
            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::WOUNDS, 4],
            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::SPEAR, MeleeWeaponsTable::WEIGHT, 1.2],

            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::REQUIRED_STRENGTH, 1],
            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::WOUNDS, 2],
            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::HOBNAILED_STAFF, MeleeWeaponsTable::WEIGHT, 1.0],

            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::REQUIRED_STRENGTH, 5],
            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::LENGTH, 5],
            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::WOUNDS, 6],
            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::LONG_SPEAR, MeleeWeaponsTable::WEIGHT, 1.5],

            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::REQUIRED_STRENGTH, 2],
            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::WOUNDS, 4],
            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::HEAVY_HOBNAILED_STAFF, MeleeWeaponsTable::WEIGHT, 1.2],

            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::REQUIRED_STRENGTH, 7],
            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::LENGTH, 6],
            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::WOUNDS, 8],
            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::PIKE, MeleeWeaponsTable::WEIGHT, 3.0],

            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::REQUIRED_STRENGTH, 5],
            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::LENGTH, 4],
            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::OFFENSIVENESS, 2],
            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::WOUNDS, 7],
            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::METAL_STAFF, MeleeWeaponsTable::WEIGHT, 2.5],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $staffsAndSpearsTable = new StaffsAndSpearsTable();
        foreach (MeleeWeaponCode::getStaffAndSpearCodes() as $staffAndSpearCode) {
            $row = $staffsAndSpearsTable->getRow([$staffAndSpearCode]);
            self::assertNotEmpty($row);
        }
    }

}
