<?php

namespace App\Twig\Runtime;

use App\Service\Utilities;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class TemplateExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private RequestStack $requestStack, private readonly Utilities $utilities
    )
    {
        // Inject dependencies if needed
    }

    public function getActiveClass($value)
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');

        return $currentRoute === $value ? 'active' : '';
    }

    public function getAvocat($value): string
    {
        return $this->utilities->transformMot($value, true);
    }

    public function getBgStatutBeneficiaire($value)
    {
        return match ($value) {
            'SELECTIONNER' => 'bg-warning fw-bold',
            'BENEFICIAIRE' => 'bg-success',
            default => '',
        };
    }

    public function getColorStatutEntrepreneuriat($value)
    {
        return match ($value) {
            'FINANCE' => 'text-primary fw-700',
            default => 'text-danger fw-700',
        };

    }
}
