<?php

namespace App\Controller;

use Elastica\Client;
use Elastica\Client as ElasticaClient;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ElasticController extends BaseController
{
    /**
     * @Route("/search", name="search")
     * @param Request        $request
     * @param ElasticaClient $client
     *
     * @return Response
     */
    public function elasticaSearch(Request $request, Client $client) : Response
    {

        $query = $request->query->get('q', '');
        $limit = $request->query->get('l', 100);

        $match = new MultiMatch();
        $match->setQuery($query);
        $match->setFields(["name", "description", "patterns", "sizes", "collars", "brand", "handles", "styles"]);
        $match->setFuzziness('AUTO');
        $match->setType('most_fields');
        $match->setOperator();

        $bool = new BoolQuery();
        $bool->addShould($match);

        $elasticaQuery = new Query($bool);
        $elasticaQuery->setSize($limit);

        $foundPatterns = $client->getIndex('pattern')->search($elasticaQuery);
        $patterns = [];
        foreach ($foundPatterns as $pattern) {
            $patternResult = $this->patternRepository->findOneBy(['id' => $pattern->getId()]);
            $patterns[] = $patternResult;
        }

        $foundBrands = $client->getIndex('brand')->search($elasticaQuery);
        $brands = [];
        foreach ($foundBrands as $brand) {
            $brandResult = $this->brandRepository->findOneBy(['id' => $brand->getId()]);
            $brands[] = $brandResult;

        }
        $countBrands = count($brands);
        $countPatterns = count($patterns);

        return $this->render('front_office/search.html.twig', [
            'patterns' => $patterns,
            'brands' => $brands,
            'countPatterns' => $countPatterns,
            'countBrands' => $countBrands
        ]);
    }
}