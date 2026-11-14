<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Backend;

use Neo\BrevoNewsletterBundle\Backend\FieldLock;
use PHPUnit\Framework\TestCase;

final class FieldLockTest extends TestCase
{
    protected function setUp(): void
    {
        $GLOBALS['TL_DCA']['tl_module']['fields'] = [
            'brevo_lists' => ['inputType' => 'checkbox', 'eval' => ['mandatory' => true, 'tl_class' => 'w50']],
            'brevo_redirect' => ['inputType' => 'pageTree', 'eval' => ['mandatory' => true]],
            'brevo_lists_label' => ['label' => ['Label of the choice', 'Help'], 'inputType' => 'text'],
        ];
        $GLOBALS['TL_LANG']['tl_module']['brevo_lists'] = ['Lists', 'Help of the lists'];
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TL_DCA'], $GLOBALS['TL_LANG'], $GLOBALS['TL_CSS']);
    }

    public function testALockedFieldIsDisabledWithTheReasonInPlaceOfItsHelp(): void
    {
        FieldLock::lock('tl_module', 'brevo_lists', 'No key yet.');

        $field = $GLOBALS['TL_DCA']['tl_module']['fields']['brevo_lists'];
        $this->assertSame(['Lists', 'No key yet.'], $field['label']);
        $this->assertTrue($field['eval']['disabled']);
        $this->assertFalse($field['eval']['mandatory'], 'the rest of the form can be saved');
        $this->assertSame('w50 brevo-locked', $field['eval']['tl_class']);
        $this->assertSame('bundles/neobrevonewsletter/backend.css|static', $GLOBALS['TL_CSS']['neo_brevo_backend']);
    }

    public function testAPickerKeepsWorkingAndOnlyShowsTheReason(): void
    {
        FieldLock::lock('tl_module', 'brevo_redirect', 'Reason');

        $field = $GLOBALS['TL_DCA']['tl_module']['fields']['brevo_redirect'];
        $this->assertArrayNotHasKey('disabled', $field['eval']);
        $this->assertTrue($field['eval']['mandatory']);
        $this->assertSame(['brevo_redirect', 'Reason'], $field['label']);
    }

    public function testAWarningLeavesTheFieldEditable(): void
    {
        FieldLock::warn('tl_module', 'brevo_lists_label', 'Only with the mode Choice.');

        $field = $GLOBALS['TL_DCA']['tl_module']['fields']['brevo_lists_label'];
        $this->assertSame(['Label of the choice', 'Only with the mode Choice.'], $field['label']);
        $this->assertArrayNotHasKey('disabled', $field['eval'] ?? []);
        $this->assertSame('brevo-locked', $field['eval']['tl_class']);
    }

    public function testNothingHappensWithoutFieldOrReason(): void
    {
        $before = $GLOBALS['TL_DCA'];

        FieldLock::lock('tl_module', 'missing', 'Reason');
        FieldLock::lock('tl_module', 'brevo_lists', '');

        $this->assertSame($before, $GLOBALS['TL_DCA']);
        $this->assertArrayNotHasKey('TL_CSS', $GLOBALS);
    }
}
