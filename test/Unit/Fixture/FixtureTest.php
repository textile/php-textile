<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Fixture;

use Netcarver\Textile\Test\Helper\Fixture;
use Netcarver\Textile\Test\Helper\FixtureProvider;

final class FixtureTest extends AbstractFixtureTest
{
    /**
     * Test fixtures.
     *
     * @param Fixture $fixture
     *
     * @dataProvider dataProvider
     */
    public function testFixture(Fixture $fixture): void
    {
        $this->assertTextileFixture($fixture);
    }

    /**
     * Data provider.
     *
     * @return array[]
     */
    public function dataProvider(): array
    {
        $provider = new FixtureProvider();

        return $provider->getFixtures();
    }
}
