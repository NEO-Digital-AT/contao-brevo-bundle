<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Backend;

use Neo\BrevoNewsletterBundle\Backend\ModuleCallbacks;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ModuleCallbacksTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($GLOBALS['TL_DCA']);
    }

    public function testEmptyTextFieldsShowTheStandardTextAsPlaceholder(): void
    {
        $GLOBALS['TL_DCA']['tl_module']['fields'] = ['brevo_button' => ['inputType' => 'text'], 'brevo_error_limit' => ['inputType' => 'text']];

        $translator = $this->createStub(TranslatorInterface::class);
        $translator->method('trans')->willReturnCallback(static fn (string $id, array $parameters = [], string|null $domain = null): string => $domain.':'.$id);

        (new ModuleCallbacks($translator))->placeholders();

        $this->assertSame('neo_brevo:form.button', $GLOBALS['TL_DCA']['tl_module']['fields']['brevo_button']['eval']['placeholder']);
        $this->assertSame('neo_brevo:form.error_limit', $GLOBALS['TL_DCA']['tl_module']['fields']['brevo_error_limit']['eval']['placeholder']);
        $this->assertArrayNotHasKey('brevo_success', $GLOBALS['TL_DCA']['tl_module']['fields'], 'only existing fields');
    }

    /**
     * Every standard text the module and its placeholders use exists in every language.
     */
    public function testEveryStandardTextExistsInEveryLanguage(): void
    {
        $keys = ['email_label', 'button', 'success', 'lists_legend', 'list_label', 'error_invalid', 'error_choose', 'error_limit', 'error_generic'];
        $files = glob(\dirname(__DIR__, 2).'/translations/neo_brevo.*.yaml') ?: [];

        $this->assertCount(11, $files);

        foreach ($files as $file) {
            $texts = Yaml::parseFile($file);

            foreach ($keys as $key) {
                $this->assertNotEmpty($texts['form'][$key] ?? null, basename($file).': form.'.$key);
            }
        }
    }
}
