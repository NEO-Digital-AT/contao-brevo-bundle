<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Backend;

use Neo\BrevoNewsletterBundle\Backend\CreditNote;
use PHPUnit\Framework\TestCase;

final class CreditNoteTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($GLOBALS['TL_LANG']);
    }

    public function testTheNameInTheTextBecomesTheLink(): void
    {
        $this->assertSame(
            'Accessibility panel: NEO Accessibility by <a href="https://neo-digital.at" rel="nofollow">NEO Digital</a>',
            CreditNote::html('Accessibility panel: NEO Accessibility by NEO Digital'),
        );
    }

    public function testATextWithoutTheNameGetsTheLinkAppended(): void
    {
        $this->assertSame('Panel &lt;b&gt; – <a href="https://neo-digital.at" rel="nofollow">NEO Digital</a>', CreditNote::html('Panel <b>'));
    }

    public function testOnlyTheFirstMentionIsLinked(): void
    {
        $this->assertSame(1, substr_count(CreditNote::html('NEO Digital and NEO Digital'), '<a '));
    }

    public function testTheNoteShowsTheLinkAndTheHtmlToCopy(): void
    {
        $html = CreditNote::render('Free <licence>', 'Text:', 'HTML:', 'Panel by NEO Digital');

        $this->assertStringContainsString('<p class="tl_info" style="margin:0 0 10px">Free &lt;licence&gt;</p>', $html);
        $this->assertStringContainsString('<a href="https://neo-digital.at" rel="nofollow noopener" target="_blank" style="text-decoration:underline">NEO Digital</a>', $html);
        $this->assertStringContainsString('Panel by &lt;a href=&quot;https://neo-digital.at&quot; rel=&quot;nofollow&quot;&gt;NEO Digital&lt;/a&gt;', $html, 'the HTML to copy, as text');
    }

    public function testForTableTakesTheTextsOfTheTable(): void
    {
        $GLOBALS['TL_LANG']['tl_module'] = [
            'brevo_licence_text' => 'Condition',
            'brevo_licence_example_label' => 'Copy:',
            'brevo_licence_html_label' => 'Or HTML:',
            'brevo_licence_example' => 'Panel by NEO Digital',
        ];

        $html = CreditNote::forTable('tl_module', 'brevo_licence_');

        $this->assertStringContainsString('>Condition</p>', $html);
        $this->assertStringContainsString('>Copy:</p>', $html);
        $this->assertStringContainsString('>Or HTML:</p>', $html);
    }
}
