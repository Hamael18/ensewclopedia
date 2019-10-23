<?php
namespace App\Command;

use App\Elasticsearch\BrandIndexer;
use App\Elasticsearch\PatternIndexer;
use App\Service\IndexBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class ElasticReindexCommand
 *
 * @author Julie
 */
class ElasticReindexCommand extends Command
{
    protected static $defaultName = 'elastic:reindex';

    private $indexBuilder;
    private $brandIndexer;
    private $patternIndexer;

    public function __construct(IndexBuilder $indexBuilder, BrandIndexer $brandIndexer, PatternIndexer $patternIndexer)
    {
        $this->indexBuilder = $indexBuilder;
        $this->brandIndexer = $brandIndexer;
        $this->patternIndexer = $patternIndexer;


        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Rebuild the Index and populate it.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $index = $this->indexBuilder->createBrand();
//        $index = $this->indexBuilder->createPattern();

        $io->success('Index created!');

        $this->brandIndexer->indexAllDocuments($index->getName());
//        $this->patternIndexer->indexAllDocuments($index->getName());

        $io->success('Index populated and ready!');
    }
}