<?php

namespace pkmnfriends\Console\Commands;

use Predis\Client as PredisClient;
use Repat\CrawlQueue\RedisCrawlQueue;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlInternalUrls;
use pkmnfriends\App\Crawlers\Observers\PokemonGoFriendCodesCrawlObserver;
use pkmnfriends\Infrastructure\Contracts\Commands\CommandAbstract;

class CrawlPokemonGoFriendCodesCommand extends CommandAbstract
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'crawler:pokemongofriendcodes
     {--maximum-crawl= : Maximum crawled page(s) (integer)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl pokemongofriendcodes.com';

    /**
     * @var string
     */
    protected $crawlerPrefix = 'crawler-pokemongofriendcodes';

    /**
     * @var string
     */
    protected $urlToCrawl = 'https://www.pokemongofriendcodes.com';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $maximumCrawl = $this->option('maximum-crawl');
        $crawler = Crawler::create()
            ->setUserAgent(config('app.name'))
            ->respectRobots()
            ->doNotExecuteJavaScript()
            ->setConcurrency(1)
            ->setDelayBetweenRequests(300)
            ->setCrawlProfile(new CrawlInternalUrls($this->urlToCrawl))
            ->setCrawlQueue(
                new RedisCrawlQueue(
                    new PredisClient(config('database.redis.crawler')),
                    $this->crawlerPrefix
                )
            )
            ->setCrawlObserver(new PokemonGoFriendCodesCrawlObserver());

        if ($maximumCrawl && is_numeric($maximumCrawl)) {
            $crawler->setMaximumCrawlCount(intval($maximumCrawl, 10));
        }

        $crawler->startCrawling($this->urlToCrawl);

        return 0;
    }
}
