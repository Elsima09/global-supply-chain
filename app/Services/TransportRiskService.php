<?php

namespace App\Services;

use App\Models\Port;

class TransportRiskService
{
    public function calculate(Port $port)
    {
        $risk = 0;

        // Status Pelabuhan
        switch ($port->status) {

            case 'Closed':
                $risk += 50;
                break;

            case 'Delayed':
                $risk += 30;
                break;

            case 'Congested':
                $risk += 20;
                break;

            default:
                $risk += 0;
        }

        // Delay
        if ($port->delay_hours >= 12) {

            $risk += 30;

        } elseif ($port->delay_hours >= 6) {

            $risk += 20;

        } elseif ($port->delay_hours >= 2) {

            $risk += 10;

        }

        // Capacity
        if ($port->capacity < 50) {

            $risk += 20;

        } elseif ($port->capacity < 70) {

            $risk += 10;

        }

        return min($risk, 100);
    }
}