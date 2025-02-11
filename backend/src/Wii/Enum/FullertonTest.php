<?php
namespace Wii\Enum;

class FullertonTest {
    public const CHAIR_STAND = 'chair_stand';
    public const ARM_CURL = 'arm_curl';
    public const SIX_MIN_WALK = 'six_min_walk';
    public const TWO_MIN_STEP = 'two_min_step';
    public const CHAIR_SIT_AND_REACH = 'chair_sit_and_reach';
    public const BACK_SCRATCH = 'back_scratch';
    public const EIGHT_FT_UP_AND_GO = 'eight_ft_up_and_go';

    public static function cases(): array {
        return [
            self::CHAIR_STAND,
            self::ARM_CURL,
            self::SIX_MIN_WALK,
            self::TWO_MIN_STEP,
            self::CHAIR_SIT_AND_REACH,
            self::BACK_SCRATCH,
            self::EIGHT_FT_UP_AND_GO,
        ];
    }
}