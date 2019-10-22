<?php

namespace App\Controller;

use Elastica\Client;
use Elastica\Client as ElasticaClient;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Elasticsearch\ClientBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ElasticController extends AbstractController
{
    /**
     * @Route("/search", name="searchTest")
     * @param Request        $request
     * @param ElasticaClient $client
     *
     * @return Response
     */
    public function elasticaSearch(Request $request, Client $client) : Response
    {

        $query = $request->query->get('q', '');
        $limit = $request->query->get('l', 10);

        $match = new MultiMatch();
        $match->setQuery($query);
        $match->setFields(["name", "description", "patterns"]);

        $bool = new BoolQuery();
        $bool->addShould($match);

        $elasticaQuery = new Query($bool);
        $elasticaQuery->setSize($limit);

        $foundBrands = $client->getIndex('brand')->search($elasticaQuery);
        $results = [];
        foreach ($foundBrands as $brand) {
            $results[] = $brand->getSource();
        }
        $foundPatterns = $client->getIndex('pattern')->search($elasticaQuery);
        foreach ($foundPatterns as $pattern) {
            $results[] = $pattern->getSource();
        }

        dump($results);

        return $this->render('elastic/search.html.twig', [
            'results' => $results,
        ]);
    }
}