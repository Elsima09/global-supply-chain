<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentWordSeeder extends Seeder
{
    public function run(): void
    {


        $positiveWords = [

            'growth',
            'increase',
            'improve',
            'improved',
            'strong',
            'stable',
            'success',
            'successful',
            'profit',
            'surplus',
            'recovery',
            'boost',
            'expand',
            'expansion',
            'gain',
            'healthy',
            'safe',
            'excellent',
            'positive',
            'rise',
            'rising',
            'higher',
            'agreement',
            'opportunity',
            'investment',
            'development'

        ];



        foreach($positiveWords as $word)
        {

            PositiveWord::firstOrCreate([
                'word'=>$word
            ]);

        }



        $negativeWords = [

            'crisis',
            'decline',
            'drop',
            'loss',
            'risk',
            'war',
            'conflict',
            'slow',
            'slows',
            'fall',
            'falling',
            'negative',
            'shortage',
            'problem',
            'disruption',
            'delay',
            'failure',
            'danger',
            'inflation',
            'sanction',
            'collapse',
            'strike',
            'uncertainty',
            'threat',
            'damage'

        ];



        foreach($negativeWords as $word)
        {

            NegativeWord::firstOrCreate([
                'word'=>$word
            ]);

        }


    }
}