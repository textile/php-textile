<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Fixture;

use DI\Container;
use Netcarver\Textile\Parser;
use Netcarver\Textile\Provider\PcreUnicodeProvider;
use Netcarver\Textile\Test\Helper\Fixture;
use Netcarver\Textile\Test\Helper\FixtureProvider;

final class NoUnicodeFixtureTest extends AbstractFixtureTest
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
        $pcreUnicodeProvider = $this->getMockBuilder(PcreUnicodeProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pcreUnicodeProvider
            ->expects($this->atLeastOnce())
            ->method('isSupported')
            ->willReturn(false);

        $container = new Container();

        $parser = $container->make(Parser::class, [
            'pcreUnicodeProvider' => $pcreUnicodeProvider,
        ]);

        $fixture->setParser($parser);

        $this->assertTextileFixture($fixture);
    }

    public function dataProvider(): array
    {
        $provider = new FixtureProvider();

        return $provider->getFixtures('no-unicode');
    }
}
