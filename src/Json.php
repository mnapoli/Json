<?php
declare(strict_types = 1);

namespace Innmind\Json;

use Innmind\Json\Exception\{
    MaximumDepthExceeded,
    StateMismatch,
    CharacterControlError,
    SyntaxError,
    MalformedUTF8,
    RecursiveReference,
    InfiniteOrNanCannotBeEncoded,
    ValueCannotBeEncoded,
    PropertyCannotBeEncoded,
    MalformedUTF16,
};

final class Json
{
    private function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function decode(string $string)
    {
        $content = json_decode($string, true);

        self::throwOnError();

        return $content;
    }

    /**
     * @param mixed $content
     */
    public static function encode($content): string
    {
        $json = json_encode($content);

        self::throwOnError();

        return $json;
    }

    private static function throwOnError(): void
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                //pass
                break;

            case JSON_ERROR_DEPTH:
                throw new MaximumDepthExceeded;

            case JSON_ERROR_STATE_MISMATCH:
                throw new StateMismatch;

            case JSON_ERROR_CTRL_CHAR:
                throw new CharacterControlError;

            case JSON_ERROR_SYNTAX:
                throw new SyntaxError;

            case JSON_ERROR_UTF8:
                throw new MalformedUTF8;

            case JSON_ERROR_RECURSION:
                throw new RecursiveReference;

            case JSON_ERROR_INF_OR_NAN:
                throw new InfiniteOrNanCannotBeEncoded;

            case JSON_ERROR_UNSUPPORTED_TYPE:
                throw new ValueCannotBeEncoded;

            case JSON_ERROR_INVALID_PROPERTY_NAME:
                throw new PropertyCannotBeEncoded;

            case JSON_ERROR_UTF16:
                throw new MalformedUTF16;
        }
    }
}
