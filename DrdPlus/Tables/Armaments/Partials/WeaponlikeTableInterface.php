<?php
namespace DrdPlus\Tables\Armaments\Partials;

interface WeaponlikeTableInterface extends WearableTableInterface
{
    const OFFENSIVENESS = 'offensiveness';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getOffensivenessOf($weaponlikeCode);

    const WOUNDS = 'wounds';

    /**
     * @param string $weaponlikeCode
     * @return int
     */
    public function getWoundsOf($weaponlikeCode);

    const WOUNDS_TYPE = 'wounds_type';

    /**
     * @param string $weaponlikeCode
     * @return string
     */
    public function getWoundsTypeOf($weaponlikeCode);
}