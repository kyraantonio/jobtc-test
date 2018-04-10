<?php

use Illuminate\Database\Seeder;
use Elasticsearch\ClientBuilder as ES;
use App\Models\TestCommunity;

class QuizElasticSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = ES::create()
            ->setHosts(\Config::get('elasticsearch.host'))
            ->build();

        $test = TestCommunity::all();
        if(count($test) > 0){
            foreach($test as $v){
                $community = $v->getOriginal();
                $community += $v->test->getOriginal();
                $community =(Object)$community;

                $params = [
                    'index' => 'default',
                    'type' => 'test',
                    'id' => $community->id,
                    'body' => $community
                ];
                $client->index($params);
            }
        }
    }
}
