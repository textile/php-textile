<?php

declare(strict_types=1);

namespace Netcarver\Textile\Test\Unit\Fixture;

use DI\Container;
use Netcarver\Textile\Parser;
use Netcarver\Textile\Provider\MaximumLinkIndexProvider;
use Netcarver\Textile\Test\Helper\Fixture;
use Netcarver\Textile\Test\Helper\FixtureProvider;

final class MaximumLinkIndexFixtureTest extends AbstractFixtureTest
{
    /**
     * @param Fixture $fixture
     *
     * @dataProvider dataProvider
     */
    public function testFixture(Fixture $fixture): void
    {
        $maximumLinkIndexProvider = $this->getMockBuilder(MaximumLinkIndexProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maximumLinkIndexProvider
            ->expects($this->atLeastOnce())
            ->method('getMaximumLinkIndex')
            ->willReturn(0);

        $container = new Container();

        $parser = $container->make(Parser::class, [
            'maximumLinkIndexProvider' => $maximumLinkIndexProvider,
        ]);

        $fixture->setParser($parser);

        $this->assertTextileFixture($fixture);
    }

    public function dataProvider(): array
    {
        $provider = new FixtureProvider();

        return $provider->getFixtures('maximum-link-index');
    }
}
