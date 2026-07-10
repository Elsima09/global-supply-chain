<?php

namespace App\Services;


class RecommendationService
{

    public function generate($riskLevel, $score)
    {

        if($riskLevel == "High"){

            return [
                'status' => 'Critical',

                'message' =>
                'High supply chain disruption risk detected. Immediate mitigation required.',

                'actions' => [

                    'Increase safety stock inventory',

                    'Prepare alternative suppliers',

                    'Review shipping routes',

                    'Avoid non-essential shipments'

                ]
            ];

        }


        elseif($riskLevel == "Medium"){


            return [

                'status'=>'Warning',

                'message'=>
                'Moderate supply chain risk detected. Continuous monitoring recommended.',

                'actions'=>[

                    'Monitor currency fluctuation',

                    'Track weather conditions',

                    'Evaluate logistics alternatives'

                ]

            ];


        }


        else{


            return [

                'status'=>'Stable',

                'message'=>
                'Supply chain condition is stable.',

                'actions'=>[

                    'Continue normal operation',

                    'Perform periodic monitoring'

                ]

            ];

        }

    }

}