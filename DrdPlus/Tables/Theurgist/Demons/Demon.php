<?php
declare(strict_types=1);

namespace DrdPlus\Tables\Theurgist\Demons;

use DrdPlus\BaseProperties\Will;
use DrdPlus\Codes\Theurgist\DemonBodyCode;
use DrdPlus\Codes\Theurgist\DemonCode;
use DrdPlus\Codes\Theurgist\DemonKindCode;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonAgility;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonArmor;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonCapacity;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonEndurance;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonKnack;
use DrdPlus\Tables\Theurgist\Demons\DemonParameters\DemonStrength;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Difficulty;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\SpellDuration;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Evocation;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Invisibility;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Quality;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\SpellRadius;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\Realm;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\RealmsAffection;
use DrdPlus\Tables\Theurgist\Spells\SpellParameters\SpellSpeed;
use Granam\Strict\Object\StrictObject;

class Demon extends StrictObject
{
    /**
     * @var DemonCode
     */
    private $demonCode;
    /**
     * @var Realm
     */
    private $realm;
    /**
     * @var Evocation
     */
    private $evocation;
    /**
     * @var DemonBodyCode
     */
    private $demonBodyCode;
    /**
     * @var DemonKindCode
     */
    private $demonKindCode;
    /**
     * @var RealmsAffection
     */
    private $realmsAffection;
    /**
     * @var Will
     */
    private $will;
    /**
     * @var Difficulty
     */
    private $difficulty;
    /**
     * @var SpellDuration
     */
    private $duration;
    /**
     * @var DemonCapacity
     */
    private $demonCapacity;
    /**
     * @var DemonEndurance
     */
    private $demonEndurance;
    /**
     * @var DemonTrait[]
     */
    private $demonTraits;
    /**
     * @var SpellSpeed
     */
    private $spellSpeed;
    /**
     * @var Quality
     */
    private $quality;
    /**
     * @var SpellRadius
     */
    private $spellRadius;
    /**
     * @var Invisibility
     */
    private $invisibility;
    /**
     * @var DemonStrength
     */
    private $demonStrength;
    /**
     * @var DemonAgility
     */
    private $demonAgility;
    /**
     * @var DemonKnack
     */
    private $demonKnack;
    /**
     * @var DemonArmor
     */
    private $demonArmor;

    /**
     * Demon constructor.
     * @param DemonCode $demonCode
     * @param Realm $realm
     * @param Evocation $evocation
     * @param DemonBodyCode $demonBodyCode
     * @param DemonKindCode $demonKindCode
     * @param RealmsAffection $realmsAffection
     * @param SpellDuration $duration
     * @param Difficulty $difficulty
     * @param array|DemonTrait[] $demonTraits
     * @param DemonCapacity $demonCapacity
     * @param DemonEndurance $demonEndurance
     * @param Will $will
     * @param SpellSpeed $spellSpeed
     * @param Quality $quality
     * @param SpellRadius $spellRadius
     * @param Invisibility $invisibility
     * @param DemonStrength $demonStrength
     * @param DemonAgility $demonAgility
     * @param DemonKnack $demonKnack
     * @param DemonArmor $demonArmor
     */
    public function __construct(
        DemonCode $demonCode,
        Realm $realm,
        Evocation $evocation,
        DemonBodyCode $demonBodyCode,
        DemonKindCode $demonKindCode,
        RealmsAffection $realmsAffection,
        SpellDuration $duration,
        Difficulty $difficulty,
        array $demonTraits,
        DemonCapacity $demonCapacity,
        DemonEndurance $demonEndurance,
        Will $will,
        SpellSpeed $spellSpeed,
        Quality $quality,
        SpellRadius $spellRadius,
        Invisibility $invisibility,
        DemonStrength $demonStrength,
        DemonAgility $demonAgility,
        DemonKnack $demonKnack,
        DemonArmor $demonArmor
    )
    {
        $this->demonCode = $demonCode;
        $this->realm = $realm;
        $this->evocation = $evocation;
        $this->demonBodyCode = $demonBodyCode;
        $this->demonKindCode = $demonKindCode;
        $this->realmsAffection = $realmsAffection;
        $this->will = $will;
        $this->duration = $duration;
        $this->difficulty = $difficulty;
        $this->demonCapacity = $demonCapacity;
        $this->demonEndurance = $demonEndurance;
        $this->demonTraits = $demonTraits;
        $this->spellSpeed = $spellSpeed;
        $this->quality = $quality;
        $this->spellRadius = $spellRadius;
        $this->invisibility = $invisibility;
        $this->demonStrength = $demonStrength;
        $this->demonAgility = $demonAgility;
        $this->demonKnack = $demonKnack;
        $this->demonArmor = $demonArmor;
    }

    public function getDemonCode(): DemonCode
    {
        return $this->demonCode;
    }

    public function getRealm(): Realm
    {
        return $this->realm;
    }

    public function getEvocation(): Evocation
    {
        return $this->evocation;
    }

    public function getDemonBodyCode(): DemonBodyCode
    {
        return $this->demonBodyCode;
    }

    public function getDemonKindCode(): DemonKindCode
    {
        return $this->demonKindCode;
    }

    public function getRealmsAffection(): RealmsAffection
    {
        return $this->realmsAffection;
    }

    public function getWill(): Will
    {
        return $this->will;
    }

    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function getDuration(): SpellDuration
    {
        return $this->duration;
    }

    public function getDemonCapacity(): DemonCapacity
    {
        return $this->demonCapacity;
    }

    public function getDemonEndurance(): DemonEndurance
    {
        return $this->demonEndurance;
    }

    /**
     * @return array|DemonTrait[]
     */
    public function getDemonTraits(): array
    {
        return $this->demonTraits;
    }

    public function getSpellSpeed(): SpellSpeed
    {
        return $this->spellSpeed;
    }

    public function getQuality(): Quality
    {
        return $this->quality;
    }

    public function getSpellRadius(): SpellRadius
    {
        return $this->spellRadius;
    }

    public function getInvisibility(): Invisibility
    {
        return $this->invisibility;
    }

    public function getDemonStrength(): DemonStrength
    {
        return $this->demonStrength;
    }

    public function getDemonAgility(): DemonAgility
    {
        return $this->demonAgility;
    }

    public function getDemonKnack(): DemonKnack
    {
        return $this->demonKnack;
    }

    public function getDemonArmor(): DemonArmor
    {
        return $this->demonArmor;
    }
}