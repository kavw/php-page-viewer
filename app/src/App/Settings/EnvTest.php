<?php

declare(strict_types=1);

namespace PV\App\Settings;

use PHPUnit\Framework\TestCase;

final class EnvTest extends TestCase
{
    public function testGettingValue(): void
    {
        $name = uniqid('var');
        $value = uniqid('value');
        $_ENV[$name] = $value;

        $var = new Env($name);

        $this->assertEquals($value, $var->val);
    }

    public function testDefaultValue(): void
    {
        $name = uniqid('var');
        $defaultValue = uniqid('value');
        unset($_ENV[$name]);

        $var = new Env($name, $defaultValue);

        $this->assertEquals($defaultValue, $var->val);
    }

    public function testEmptyDefaultValue(): void
    {
        $name = uniqid('var');
        unset($_ENV[$name]);

        $var = new Env($name);

        $this->assertEquals('', $var->val);
    }
}
