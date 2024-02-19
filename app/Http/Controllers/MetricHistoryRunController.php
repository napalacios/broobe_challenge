<?php

namespace App\Http\Controllers;

use App\Models\MetricHistoryRun;
use App\Models\Category;
use App\Models\Strategy;

use GuzzleHttp\Client;
use App\Http\Requests\GetMetricsRequest;
use App\Http\Requests\SaveMetricsRequest;
use App\Http\Resources\MetricHistoryRunResource;
use Exception;

class MetricHistoryRunController extends Controller
{

    public function run()
    {   
        try {

            $categories = Category::getAll();
            $strategies = Strategy::getAll();
            return view('metric.run', compact('categories', 'strategies'));

        } catch (Exception $e) {
            return view('error');
        }
    }

    public function history()
    {
        return view('metric.history');
    }

    private function assemblSearchString($name_of_new_string, $new_string, $original_string = null)
    {
        return ($original_string) ? $original_string . '&' . $name_of_new_string . '=' . $new_string : '?' . $name_of_new_string . '=' . $new_string;
    }

    public function index()
    {
        try {

            return MetricHistoryRunResource::collection(
                MetricHistoryRun::getAll()->paginate(10)
            );

        } catch (Exception $e) {
            return json_encode(['state' => 'error']);
        }

    }

    public function create(SaveMetricsRequest $request)
    {

        try {

            $performance_metric = $accesibility_metric = $best_practices_metric = $seo_metric = $pwa_metric = NULL;

            foreach (json_decode($request->get('scores')) as $metric):

                switch ($metric->id):
                    case 'performance':
                        $performance_metric = $metric->score;
                        break;
                    case 'accessibility':
                        $accesibility_metric = $metric->score;
                        break;
                    case 'best-practices':
                        $best_practices_metric = $metric->score;
                        break;
                    case 'seo':
                        $seo_metric = $metric->score;
                        break;
                    case 'pwa':
                        $pwa_metric = $metric->score;
                        break;
                    endswitch;
            endforeach;

            MetricHistoryRun::create([
                'url' => $request->get('url'),
                'accesibility_metric' => $accesibility_metric,
                'pwa_metric' => $pwa_metric,
                'performance_metric' => $performance_metric,
                'seo_metric' => $seo_metric,
                'best_practices_metric' => $best_practices_metric,
                'strategy_id' => $request->get('strategy'),
            ]);

            return json_encode(['state' => 'ok']);
        } catch (Exception $e) {
            return json_encode(['state' => 'error']);
        }
    }

    private function getSearchString($request){

        $search_string = '';
        $categories = json_decode($request->get('categories'));
        
        $search_string = $this->assemblSearchString('url', $request->get('url'));
        $search_string = $this->assemblSearchString('strategy', Strategy::getById($request->get('strategy'))->id, $search_string);
        $search_string = $this->assemblSearchString('key', 'AIzaSyDCrPAzhzWxZbJxPYIEURODTvBFVVRNHbY', $search_string);
        
        foreach($categories as $category):

            $search_string = $this->assemblSearchString('category', Category::getById($category)->id, $search_string);

        endforeach;

        return $search_string;

    }    

    public function getMetrics(GetMetricsRequest $request)
    {

        try {
            
            $client = new Client(['base_uri' => '']);            
            $response = $client->request('GET', 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed' . $this->getSearchString($request));

            if($response->getStatusCode() != 200):
                return json_encode(['state' => 'error']);
            endif;

            $body = (string) $response->getBody();
            $body_decode = json_decode($body);
            $scores = array();

            foreach($body_decode->lighthouseResult->categories as $category):
                $scores[] = array(
                    "id" => $category->id,
                    "title" => $category->title,
                    "score" => $category->score,
                );
            endforeach;

            return json_encode(['state' => 'ok', 'scores' => $scores]);
            
        } catch (Exception $e) {
            return json_encode(['state' => 'error']);
        }
    }
}
