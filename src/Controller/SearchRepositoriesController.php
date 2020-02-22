<?php


namespace App\Controller;

use App\Form\SearchType;
use App\Http\SearchActionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SearchRepositoriesController extends AbstractController
{
    /**
     * @var SearchActionHandler
     */
    private SearchActionHandler $searchActionHandler;

    public function __construct(SearchActionHandler $searchActionHandler)
    {
        $this->searchActionHandler = $searchActionHandler;
    }

    /**
     * @param Request $request
     * @Route(path="/api/search", methods={"POST"})
     * @return JsonResponse
     */
    public function searchAction(Request $request): JsonResponse
    {
        $content = $request->getContent();
        if (empty($content)) {
            throw new BadRequestHttpException('Request content is empty');
        }
        $params = json_decode($content, true);
        if (!$params) {
            throw new BadRequestHttpException('Request content is empty');
        }
        $form = $this->createForm(SearchType::class);
        $form->submit($params);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $this->searchActionHandler->handleSearch($form->getData());
            return $this->json($data);
        }
        throw new BadRequestHttpException('Wrong input data. ' . (string) $form->getErrors());
    }
}
