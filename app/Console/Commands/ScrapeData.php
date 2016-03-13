<?php

namespace App\Console\Commands;

use App\Word;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urban:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape top words';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        foreach($alphabet as $letter) {
            $this->info('Letter: '. $letter);
            $client = new Client();
            $resp = $client->get('http://www.urbandictionary.com/popular.php?character='.$letter);
            $html = $resp->getBody()->getContents();
            $crawler = new Crawler($html);
            $wordlinks = $crawler->filter('.panel.collection-panel a.popular');
            foreach ($wordlinks as $wordlink) {
                $term = $wordlink->nodeValue;
                $this->info('Term: '. $term);
                $word = new Word();
                $word->term = $term;
                $word->save();
            }
        }
    }
}
