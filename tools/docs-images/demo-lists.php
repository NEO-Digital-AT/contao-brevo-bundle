<?php

declare(strict_types=1);

/*
 * Stand-in for a Brevo account in a test installation: puts example lists and a
 * double opt-in template into the cache under the stored API key, where the
 * back end looks for Brevo's answer (BrevoClient, one hour). The back end then
 * shows them as if the account had them; nothing is sent to Brevo.
 *
 *     php demo-lists.php <project directory> <en|de>
 */

use Contao\ManagerBundle\HttpKernel\ContaoKernel;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;

[, $project, $lang] = $argv + [null, null, 'en'];

require $project.'/vendor/autoload.php';

$names = [
    'en' => [[2 => 'Newsletter', 3 => 'Customers'], [1 => 'Double opt-in confirmation (#1)']],
    'de' => [[2 => 'Newsletter', 3 => 'Kunden'], [1 => 'Double-Opt-in-Bestätigung (#1)']],
][$lang] ?? null;

if (null === $names) {
    fwrite(STDERR, "Language en or de.\n");
    exit(2);
}

$kernel = ContaoKernel::fromRequest($project, Request::create('/'));
// In the prod environment the kernel comes wrapped in the HTTP cache.
$kernel = $kernel instanceof HttpCache ? $kernel->getKernel() : $kernel;
$kernel->boot();
$container = $kernel->getContainer();
$container->get('contao.framework')->initialize();
$key = $container->get(ApiKeyResolver::class)->resolve();

if ('' === $key) {
    fwrite(STDERR, "No Brevo API key stored on Access keys and licences.\n");
    exit(1);
}

$cache = $container->get('cache.app');

foreach (['neo_brevo_lists_' => $names[0], 'neo_brevo_templates_' => $names[1]] as $prefix => $value) {
    $item = $cache->getItem($prefix.hash('sha256', $key));
    $item->set($value)->expiresAfter(3600);
    $cache->save($item);
}

echo "Example lists and template cached for one hour.\n";
