<?php

namespace App\Console\Commands;

use App\Word;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetGifs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urban:gifs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Gifs';

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
        foreach($words as $k => $word) {
            $this->info($word['term']);
            $term = $word['term'];
            $keywords = [];
            if(count(explode(' ', $term)) > 0){
                foreach(explode(' ', $term) as $keyword){
                    $keywords[] = $keyword;
                }
            }
            $definition = explode(' ', str_replace('.','',$word['definition']));
            foreach($definition as $key => $keyword) {
                if($key > 10) {
                    break;
                }
                if(!in_array($keyword, $this->conjunctions())){
                    $keywords[] = $this->cleanWord($keyword);
                }
            }
            // Get Gifs
            $gifs = $this->getGifs($keywords);
            print_r($gifs);
            $word['gifs'] = $gifs;
            $word->save();
        }
    }

    private function getGifs($keywords) {
        $the_gifs = [];
        foreach($keywords as $key => $keyword) {
            $client = new Client();
            $resp = $client->get('http://api.giphy.com/v1/gifs/search?q='.urlencode($keyword).'&api_key=dc6zaTOxFJmzC');
            $data = json_decode($resp->getBody()->getContents(), true);
            $gifs = $data['data'];
            if($key == 0) {
                if(count($gifs) > 0) {
                    foreach($gifs as $k => $gif) {
                        if($k > 9) { $the_gifs[] = $gif['images']['original']['url']; }
                    }
                }
            }
            if(count($gifs) > 0) {
                $the_gifs[] = $gifs[0]['images']['original']['url'];
            }

        }
        return $the_gifs;
    }

    private function cleanWord($word) {
        return str_replace(array('.', ' ', "\n", "\t", "\r"), '', $word);
    }

    private function conjunctions() {
        return array_merge([
            'and',
            'that',
            'this',
            'but',
            'or',
            'as',
            'at',
            'of',
            'if',
            'when',
            'than',
            'because',
            'while',
            'where',
            'after',
            'so',
            'though',
            'since',
            'until',
            'whether',
            'before',
            'although',
            'nor',
            'like',
            'once',
            'unless',
            'now',
            'except',
            'a',
            'an',
        ], [
            'after',
            'although',
            'and',
            'as',
            'far',
            'how',
            'long',
            'if',
            'soon',
            'though',
            'well',
            'because',
            'before',
            'both',
            'but',
            'either',
            'even',
            'even',
            'though',
            'for',
            'how',
            'however',
            'only',
            'in',
            'order',
            'that',
            'neither',
            'nor',
            'now',
            'once',
            'only',
            'or',
            'provided',
            'rather',
            'than',
            'since',
            'so',
            'that',
            'than',
            'that',
            'though',
            'till',
            'unless',
            'until',
            'when',
            'whenever',
            'where',
            'whereas',
            'wherever',
            'whether',
            'while',
            'yet',
        ]);
    }
}
