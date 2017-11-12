<?php
declare(strict_types=1);
namespace Enginewerk\Promas\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function searchAction()
    {
        return new JsonResponse(['success']);
    }

    public function investmentAction(Request $request)
    {
        $result = $this
            ->get('enginewerk_promas_search.service.finder_service')
            ->findByInvestment($request->get('investment'));

        return new JsonResponse($result);
    }
}
