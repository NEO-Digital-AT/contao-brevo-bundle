<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Backend;

use Doctrine\DBAL\Connection;
use Neo\BrevoNewsletterBundle\Backend\DependencyCallbacks;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\Tests\Support\DataContainers;
use Neo\BrevoNewsletterBundle\Tests\Support\Database;
use Neo\BrevoNewsletterBundle\Tests\Support\RecordingClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Lists and template of the Brevo account: disabled with the reason while
 * there is nothing to choose, the stored choice kept.
 */
final class DependencyCallbacksTest extends TestCase
{
    use DataContainers;

    private Connection $db;

    protected function setUp(): void
    {
        $this->db = Database::connection();
        $this->db->insert('tl_module', ['id' => 5, 'type' => 'brevo_newsletter', 'brevo_lists' => serialize(['7', '3']), 'brevo_doi_template' => 4, 'brevo_mode' => 'fixed']);
        $this->db->insert('tl_module', ['id' => 6, 'type' => 'navigation']);
        $this->db->insert('tl_form_field', ['id' => 2, 'type' => 'brevo_optin', 'brevo_lists' => serialize([]), 'brevo_doi_template' => 0]);

        include \dirname(__DIR__, 2).'/contao/languages/en/tl_module.php';
        include \dirname(__DIR__, 2).'/contao/languages/en/tl_form_field.php';

        foreach (['tl_module', 'tl_form_field'] as $table) {
            $GLOBALS['TL_DCA'][$table]['fields'] = [
                'brevo_lists' => ['inputType' => 'checkbox', 'options_callback' => ['x', 'lists'], 'eval' => ['mandatory' => true]],
                'brevo_doi_template' => ['inputType' => 'select', 'options_callback' => ['x', 'templates'], 'eval' => ['mandatory' => true]],
                'brevo_lists_label' => ['inputType' => 'text'],
            ];
        }
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TL_DCA'], $GLOBALS['TL_LANG'], $GLOBALS['TL_CSS']);
    }

    public function testWithoutKeyListsAndTemplateAreLockedAndTheStoredChoiceIsShownById(): void
    {
        $http = new RecordingClient();

        $this->callbacks($http, '')->lock($this->dataContainer('', 5, 'tl_module'));

        $fields = $GLOBALS['TL_DCA']['tl_module']['fields'];
        $this->assertTrue($fields['brevo_lists']['eval']['disabled']);
        $this->assertTrue($fields['brevo_doi_template']['eval']['disabled']);
        $this->assertSame($GLOBALS['TL_LANG']['tl_module']['brevo_locked_no_key'], $fields['brevo_lists']['label'][1]);
        $this->assertSame([7 => '#7', 3 => '#3'], $fields['brevo_lists']['options']);
        $this->assertArrayNotHasKey('options_callback', $fields['brevo_lists']);
        $this->assertSame([4 => '#4'], $fields['brevo_doi_template']['options']);
        $this->assertSame([], $http->requests, 'Brevo is not asked without a key');
    }

    public function testWithoutAnswerFromBrevoTheReasonSaysSo(): void
    {
        $this->callbacks(new RecordingClient(RecordingClient::json(['message' => 'Key not found'], 401)), 'xkeysib-wrong')->lock($this->dataContainer('', 2, 'tl_form_field'));

        $fields = $GLOBALS['TL_DCA']['tl_form_field']['fields'];
        $this->assertSame($GLOBALS['TL_LANG']['tl_form_field']['brevo_locked_no_answer'], $fields['brevo_lists']['label'][1]);
        $this->assertSame([], $fields['brevo_lists']['options']);
        $this->assertArrayNotHasKey('brevo-locked', array_flip(explode(' ', $fields['brevo_lists_label']['eval']['tl_class'] ?? '')), 'the label of the choice is a module field only');
    }

    public function testWithListsFromBrevoNothingIsLocked(): void
    {
        $this->callbacks(new RecordingClient(RecordingClient::json(['lists' => [['id' => 7, 'name' => 'Newsletter']]])), 'xkeysib-test')->lock($this->dataContainer('', 5, 'tl_module'));

        $fields = $GLOBALS['TL_DCA']['tl_module']['fields'];
        $this->assertArrayNotHasKey('disabled', $fields['brevo_lists']['eval']);
        $this->assertSame(['x', 'lists'], $fields['brevo_lists']['options_callback']);
        $this->assertTrue($fields['brevo_lists_label']['eval']['disabled'], 'fixed mode: the label of the choice has no effect');
        $this->assertSame($GLOBALS['TL_LANG']['tl_module']['brevo_locked_choice'], $fields['brevo_lists_label']['label'][1]);
    }

    public function testOtherRecordsAndViewsAreLeftAlone(): void
    {
        $before = $GLOBALS['TL_DCA'];

        $this->callbacks(new RecordingClient(), '')->lock($this->dataContainer('', 6, 'tl_module'));
        $this->callbacks(new RecordingClient(), '', null)->lock($this->dataContainer('', 5, 'tl_module'));
        $this->callbacks(new RecordingClient(), '')->lock($this->dataContainer('', 5, 'tl_content'));

        $this->assertSame($before, $GLOBALS['TL_DCA']);
    }

    private function callbacks(RecordingClient $http, string $key, string|null $act = 'edit'): DependencyCallbacks
    {
        $stack = new RequestStack();
        $stack->push(Request::create('/contao'.(null !== $act ? '?act='.$act : '')));

        return new DependencyCallbacks(new ApiKeyResolver(Database::settings($this->db, $key)), new BrevoClient($http->client, new ArrayAdapter()), $this->db, $stack);
    }
}
