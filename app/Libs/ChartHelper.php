<?php


namespace App\Libs;


use Illuminate\Database\Eloquent\Casts\Json;

class ChartHelper
{

    /**
     * Lib : vue-chart and chart.js
     */


    /**
     * @param $title
     * @return array
     * Generate default options desgined to project
     */
    public static function generateOptions($title)
    {

        $options = array(
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => array(
                'responsive' => true,
                'maintainAspectRatio' => false,
                'tooltip' => array(
                    'bodyColor' => 'white',
                    'backgroundColor' => '#03A9F4'
                ),
                'title' => array(
                    'display' => true,
                    'text' => $title,
                    'color' => '#03A9F4',
                    'position' => 'top',
                    'align' => 'center',
                    'font' => array(
                        'weight' => 'bold',
                        'size' => 30
                    )
                ),
                'legend' => array(
                    'position' => 'bottom',
                    'labels' => array(
                        'font' => array(
                            'size' => 18
                        )
                    )
                )
            )
        );

        return $options;
    }

    /**
     * @return array
     * Retuen default object written in vue-chart doc
     */
    private static function generateDefaultStructure()
    {
        $chartData = [
            'labels' => [""],
            'datasets' => [],
            'options' => []
        ];
        return $chartData;
    }


    private static function getStatusColor($statusId, $vuetifyClasses = true)
    {
        switch ($statusId) {
            case 1:
                return $vuetifyClasses ? "blue-grey" : "#607D8B";
            case 2:
                return $vuetifyClasses ? "primary" : "#03A9F4";
            case 3:
                return $vuetifyClasses ? "green" : "#4CAF50";
            case 4:
                return $vuetifyClasses ? "red" : "#F44336";
            default:
                return $vuetifyClasses ? "black" : "#000000";
        }
    }


    /**
     * @param $statuses
     * @return array
     *
     * Default structure adapted to status chart
     */
    public static function generateStatus($statuses)
    {
        $chartData = self::generateDefaultStructure();
        $options = self::generateOptions('Candidature Statuses');
        $chartData['options'] = $options;


        foreach ($statuses as $status) {
            $chartData['datasets'][] = [
                'label' => [$status->name],
                'backgroundColor' => [self::getStatusColor($status->id, false)],
                'data' => [$status->amount]
            ];
        }

        return $chartData;
    }

    public static function generateProfile($profiles)
    {
        $chartData = self::generateDefaultStructure();
        $options = self::generateOptions('Professional Profiles');
        $chartData['options'] = $options;


        foreach ($profiles as $profile) {
            $chartData['datasets'][] = [
                'label' => [$profile->title],
                'backgroundColor' => [fake()->hexColor()],
                'data' => [$profile->amount]
            ];
        }

        return $chartData;
    }

}
