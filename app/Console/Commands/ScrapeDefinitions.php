<?php

namespace App\Console\Commands;

use App\Word;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeDefinitions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urban:defs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape Word Definitions';

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
        $words = Word::all();
        foreach($words as $word) {
            $client = new Client();
            $this->info($word['term']);
            $url = 'http://www.urbandictionary.com/define.php?term='.urlencode($word['term']);
            $resp = $client->get($url);
            $html = $resp->getBody()->getContents();
            $crawler = new Crawler($html);
            $meaning = $crawler->filter('.def-panel .meaning')->getNode(0);
            $word['definition'] = $meaning->textContent;
            $word->save();
        }
    }
}
