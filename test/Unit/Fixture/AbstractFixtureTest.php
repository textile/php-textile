<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Fixture;

use Netcarver\Textile\Test\Helper\Fixture;
use PHPUnit\Framework\TestCase;

abstract class AbstractFixtureTest extends TestCase
{
    /**
     * Change the working directory to the test directory.
     *
     * This jails the parser to it.
     */
    public function setUp(): void
    {
        \chdir(\dirname(\dirname(__DIR__)));
    }

    /**
     * Asserts a fixture.
     *
     * @param Fixture $fixture
     *
     * @dataProvider dataProvider
     */
    public function assertTextileFixture(Fixture $fixture): void
    {
        $this->assertTrue($fixture->isValid(), 'Fixture is invalid.');

        if ($fixture->isSkipped()) {
            $this->markTestSkipped();
        }

        $this->assertSame(
            $fixture->getExpected(),
            $fixture->getParsed(),
            'Parser results were not as expected.'
        );
    }
}
