<?php

namespace App\Console\Commands;

use App\Word;
use Illuminate\Console\Command;

class MakeLetters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urban:letters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Letters Array';

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
            $this->info($word['term']);
            $term = $word['term'];
            $letters = str_split($term);
            $word['letters'] = $letters;
            $word->save();
        }
    }
}
