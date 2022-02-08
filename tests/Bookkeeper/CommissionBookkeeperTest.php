<?php

final class CommissionBookkeeperTest extends \PHPUnit\Framework\TestCase
{
    public function testEmpty(): array
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }
}