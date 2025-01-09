<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TemplateExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TemplateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('menu_active', [TemplateExtensionRuntime::class, 'getActiveClass']),
            new TwigFilter('avocat', [TemplateExtensionRuntime::class, 'getAvocat']),
            new TwigFilter('bg_statut_beneficiaire', [TemplateExtensionRuntime::class, 'getBgStatutBeneficiaire']),
            new TwigFilter('text_statut_entrepreneuriat', [TemplateExtensionRuntime::class, 'getColorStatutEntrepreneuriat']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('menu_active', [TemplateExtensionRuntime::class, 'getActiveClass']),
        ];
    }
}
