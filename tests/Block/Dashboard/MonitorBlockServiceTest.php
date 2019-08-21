<?php

/*
 * This file is part of the ekino/sonata project.
 *
 * (c) Ekino
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\HelpersBundle\Tests\Block\Dashboard;

use Liip\MonitorBundle\Helper\PathHelper;
use PHPUnit\Framework\TestCase;
use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Test\FakeTemplating;
use Sonata\HelpersBundle\Block\Dashboard\MonitorBlockService;
use Sonata\PageBundle\Entity\BaseBlock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MonitorBlockServiceTest.
 *
 * @author Quentin Belot <quentin.belot@ekino.com>
 */
class MonitorBlockServiceTest extends TestCase
{
    /**
     * Test Get Name.
     */
    public function testGetName(): void
    {
        $pathHelper = $this->createMock(PathHelper::class);
        $templating = new FakeTemplating();
        $block      = new MonitorBlockService(MonitorBlockService::class, $templating, $pathHelper, 'defaultGroup');

        $this->assertSame(MonitorBlockService::class, $block->getName());
    }

    /**
     * Test Execute.
     */
    public function testExecute(): void
    {
        $pathHelper     = $this->createMock(PathHelper::class);
        $templating     = new FakeTemplating();
        $service        = new MonitorBlockService(MonitorBlockService::class, $templating, $pathHelper, 'defaultGroup');
        $block          = new Block();
        $optionResolver = new OptionsResolver();

        $service->configureSettings($optionResolver);

        $blockContext = new BlockContext($block, $optionResolver->resolve());

        $this->assertArrayHasKey('template', $blockContext->getSettings());

        $this->assertSame('@SonataHelpers/Block/dashboard/monitor.html.twig', $blockContext->getSettings()['template']);
        $this->assertInstanceOf(Response::class, $service->execute($blockContext));
    }
}

class Block extends BaseBlock
{
    /**
     * @var int
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
