<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Backend;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\System;
use Doctrine\DBAL\Connection;
use Neo\BrevoNewsletterBundle\Backend\KeyWarning;
use Neo\BrevoNewsletterBundle\Backend\RequestInput;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Tests\Support\DataContainers;
use Neo\BrevoNewsletterBundle\Tests\Support\Database;
use Neo\BrevoNewsletterBundle\Tests\Support\LoadedLanguageFiles;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * The message at the top of a Brevo module or form field while no key is stored.
 */
final class KeyWarningTest extends TestCase
{
    use DataContainers;

    private Connection $db;

    private RequestStack $stack;

    protected function setUp(): void
    {
        $this->db = Database::connection();
        $this->db->insert('tl_module', ['id' => 5, 'type' => 'brevo_newsletter']);
        $this->db->insert('tl_module', ['id' => 6, 'type' => 'navigation']);
        $this->db->insert('tl_form_field', ['id' => 2, 'type' => 'brevo_optin']);

        $GLOBALS['TL_LANG']['tl_neo_access']['brevo_missing'] = 'No Brevo API key stored yet.';
        $GLOBALS['TL_LANGUAGE'] = 'en';
        LoadedLanguageFiles::mark('tl_neo_access');
    }

    protected function tearDown(): void
    {
        LoadedLanguageFiles::reset();
        System::setContainer(new Container());
        unset($GLOBALS['TL_LANG'], $GLOBALS['TL_LANGUAGE']);
    }

    public function testShownInTheEditFormOfABrevoRecordWithoutKey(): void
    {
        $this->warning('edit')->add($this->dataContainer('', 5, 'tl_module'));
        $this->assertSame(['<p class="tl_error">No Brevo API key stored yet.</p>'], $this->messages());

        $this->warning('edit')->add($this->dataContainer('', 2, 'tl_form_field'));
        $this->assertCount(1, $this->messages());
    }

    public function testNotShownWithAKeyOutsideTheFormOrForOtherRecords(): void
    {
        $this->warning('edit', 'xkeysib-test')->add($this->dataContainer('', 5, 'tl_module'));
        $this->warning('')->add($this->dataContainer('', 5, 'tl_module'));
        $this->warning('edit')->add($this->dataContainer('', 6, 'tl_module'));
        $this->warning('edit')->add($this->dataContainer('', 5, 'tl_content'));

        $this->assertSame([], $this->messages());
    }

    public function testRequestInputCanSetAFormValue(): void
    {
        $stack = new RequestStack();
        $stack->push(Request::create('/contao?act=edit', 'POST'));
        $input = new RequestInput($stack);

        $input->setPost('brevo_mode', 'choice');

        $this->assertSame('choice', $input->post('brevo_mode'));
        $this->assertSame('edit', $input->query('act'));
    }

    private function warning(string $act, string $key = ''): KeyWarning
    {
        $request = Request::create('/contao'.('' !== $act ? '?act='.$act : ''));
        $request->setSession(new Session(new MockArraySessionStorage()));
        $this->stack = new RequestStack();
        $this->stack->push($request);

        $security = $this->createStub(Security::class);
        $security->method('isGranted')->willReturn(false);
        $matcher = $this->createStub(ScopeMatcher::class);
        $matcher->method('isBackendRequest')->willReturn(true);

        $container = new Container();
        $container->set('request_stack', $this->stack);
        $container->set('security.helper', $security);
        $container->set('contao.routing.scope_matcher', $matcher);
        System::setContainer($container);

        return new KeyWarning(new ApiKeyResolver(Database::settings($this->db, $key)), $this->db, new RequestInput($this->stack));
    }

    /**
     * @return list<string>
     */
    private function messages(): array
    {
        return $this->stack->getCurrentRequest()?->getSession()->getFlashBag()->peek('contao.BE.raw') ?? [];
    }
}

