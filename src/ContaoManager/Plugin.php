<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Neo\BasicBundle\NeoBasicBundle;
use Neo\BrevoNewsletterBundle\NeoBrevoNewsletterBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * Contao Manager plugin — registers the bundle and its subscribe endpoint. The
 * package is self-registering: installed via Composer, the manager-plugin is discovered through
 * composer "extra.contao-manager-plugin" and wires everything up. No host-side
 * configuration is required. Loads after the Basic bundle, which provides the
 * menu group "neo" and the page "Access keys and licences" with the API key.
 */
class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(NeoBrevoNewsletterBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, NeoBasicBundle::class]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): ?RouteCollection
    {
        $file = __DIR__.'/../../config/routes.yaml';

        return $resolver->resolve($file)->load($file);
    }
}
