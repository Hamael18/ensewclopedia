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

        $sizes = [];
        $collars = [];
        $handles = [];
        $styles = [];
        foreach ($pattern->getVersions() as $version){
            foreach ($version->getSizes() as $size)
            {
                $sizes[] = $size->getLibelle();
            };
            foreach ($version->getCollars() as $collar)
            {
                $collars[] = $collar->getName();
            }
            foreach ($version->getHandles() as $handle)
            {
                $handles[] = $handle->getName();
            }
            foreach ($version->getStyles() as $style)
            {
                $styles[] = $style->getName();
            }
        }

        $sizes = array_values(array_unique($sizes));
        sort($sizes, SORT_NUMERIC);
        $collars = array_values(array_unique($collars));
        $handles = array_values(array_unique($handles));
        $styles = array_values(array_unique($styles));

        //Get languages
        $languages = [];
        foreach ($pattern->getLanguages() as $language){
            $languages[] = $language->getName();
        }

        return new Document(
            $pattern->getId(), // Manually defined ID
            [
                'entity' => 'pattern',
                'name' => $pattern->getName(),
                'description' => $pattern->getDescription(),
                'brand'=> $brand,
                'languages'=>$languages,
                'sizes' => $sizes,
                'collars' => $collars,
                'handles' => $handles,
                'styles' => $styles,

                // Not indexed but needed for display
                'lien' => $pattern->getLien(),
                'slug' => $pattern->getSlug(),
                'id'=> $pattern->getId(),
                'image' => $pattern->getImage()
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