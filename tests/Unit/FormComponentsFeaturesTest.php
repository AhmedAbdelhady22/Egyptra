<?php

namespace Tests\Unit;

use App\Filament\Support\FormComponents;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormComponentsFeaturesTest extends TestCase
{
    #[Test]
    public function it_parses_feature_html_into_items(): void
    {
        $items = FormComponents::featuresHtmlToItems('<ul><li>Pool</li><li>Garden</li></ul>');

        $this->assertSame(['Pool', 'Garden'], $items);
    }

    #[Test]
    public function it_collapses_feature_items_into_html(): void
    {
        $html = FormComponents::featuresItemsToHtml(['Pool', 'Garden']);

        $this->assertSame('<ul><li>Pool</li><li>Garden</li></ul>', $html);
    }
}
