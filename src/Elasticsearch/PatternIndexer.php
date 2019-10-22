<?php


namespace App\Elasticsearch;

use App\Entity\Pattern;
use App\Repository\PatternRepository;
use Elastica\Client;
use Elastica\Document;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PatternIndexer
 *
 * @author Julie
 */
class PatternIndexer
{
    private $client;

    private $patternRepository;

    private $router;

    public function __construct(Client $client, PatternRepository $patternRepository, UrlGeneratorInterface $router)
    {
        $this->client = $client;
        $this->patternRepository = $patternRepository;
        $this->router = $router;
    }

    public function buildDocument(Pattern $pattern)
    {
        $brand = ($pattern->getBrand()) ? $pattern->getBrand()->getName() : "";
        return new Document(
            $pattern->getId(), // Manually defined ID
            [
                'entity' => 'pattern',
                'name' => $pattern->getName(),
                'description' => $pattern->getDescription(),
                'brand'=> $brand,
                'languages'=>$pattern->getLanguages(),
                // Not indexed but needed for display
                'lien' => $pattern->getLien(),
            ]
        );
    }

    public function indexAllDocuments($indexName)
    {
        $allPatterns = $this->patternRepository->findAll();
        $index = $this->client->getIndex($indexName);

        $documents = [];
        foreach ($allPatterns as $pattern) {
            $documents[] = $this->buildDocument($pattern);
        }

        $index->addDocuments($documents);
        $index->refresh();
    }
}