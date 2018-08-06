<?php
declare(strict_types=1);

namespace InValTest\Vals;

use InVal\Vals\IterableStringVal;
use PHPUnit\Framework\TestCase;

class IterableStringValTest extends TestCase
{
    /**
     * @dataProvider successProvider
     *
     * @param            $input
     * @param string     $message
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSuccess($input, string $message): void
    {
        $val = new IterableStringVal($input);

        self::assertTrue($val->success(), $message);
        self::assertSame($input, $val->value(), $message);
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function successProvider(): array
    {
        return [
            [[], 'An empty array'],
            [['two', 1, true, 234.23], 'Array of types that can be cast to strings.'],
        ];
    }


    /**
     * @dataProvider failureProvider
     *
     * @param            $input
     * @param string     $message
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testFailure($input, string $message): void
    {
        $val = new IterableStringVal($input);

        self::assertFalse($val->success(), $message);
        self::assertNull($val->value(), $message);
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function failureProvider(): array
    {
        $object = new class()
        {
            public function __toString()
            {
                return 'success';
            }
        };

        return [
            [[$object], 'A class with toString.'],
        ];
    }
}
