<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class KpiController extends AbstractController
{
    #[Route('/kpi', name: 'app_kpi')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $chartLine = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chartLine->setData([
            'labels' => ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samdedi', 'dimanche'],
            'datasets' => [
                [
                    'label' => 'Room per day',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);
        $chartLine->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
        $chartDoughnut = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chartDoughnut->setData([
            'labels' => ['nourriture', 'produits', 'personelle', 'travaux'],
            'datasets' => [
                [
                    'label' => 'Room per day',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [12, 10, 5, 2],
                ],
            ],
        ]);
        $chartDoughnut->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('kpi/index.html.twig', [
            'chartLine' => $chartLine,
            'chartDoughnut' => $chartDoughnut,
        ]);
    }
}
