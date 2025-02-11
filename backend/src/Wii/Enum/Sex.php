<?php
namespace Wii\Enum;

class Sex {
    public const MALE = 'M';
    public const FEMALE = 'F';

    public static function cases(): array {
        return [
            self::MALE,
            self::FEMALE
        ];
    }
}