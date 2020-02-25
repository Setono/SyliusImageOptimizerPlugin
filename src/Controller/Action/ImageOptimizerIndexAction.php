<?php

declare(strict_types=1);

namespace Setono\SyliusImageOptimizerPlugin\Controller\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ImageOptimizerIndexAction
{
    /** @var Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request): Response
    {
        return new Response($this->twig->render('@SetonoSyliusImageOptimizerPlugin/admin/image_optimizer/index.html.twig'));
    }
}
