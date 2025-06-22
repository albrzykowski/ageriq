<?php
namespace Wii\Enum;

class SPPBTest {
    public const CHAIR_STAND = 'chair_stand';
    public const BALANCE = 'balance';
    public const THREE_M_WALK = 'three_m_walk';
    public const FOUR_M_WALK = 'four_m_walk';

    public static function cases(): array {
        return [
            self::CHAIR_STAND,
            self::BALANCE,
            self::THREE_M_WALK,
            self::FOUR_M_WALK
        ];
    }
}