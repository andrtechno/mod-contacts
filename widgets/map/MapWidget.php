<?php

namespace panix\mod\contacts\widgets\map;

use Yii;
use panix\lib\google\maps\LatLng;
use panix\lib\google\maps\overlays\InfoWindow;
use panix\lib\google\maps\overlays\Marker;
use panix\lib\google\maps\Map;
use panix\lib\google\maps\MapAsset;
use panix\mod\contacts\models\Maps;
use panix\engine\data\Widget;
use yii\helpers\ArrayHelper;

/**
 * Description of Map
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */
class MapWidget extends Widget
{

    private $map;
    public $map_id;
    public $options = [];
    public static $autoIdPrefix = '';

    public function init()
    {
        parent::init();
        $view = Yii::$app->getView();
        MapAsset::register($view);
        $model = Maps::findModel($this->map_id,'Map not found.');


        $mapOptions = ArrayHelper::merge([
            'center' => new LatLng($model->getCenter()),
            'zoom' => $model->zoom,
        ], $this->options);

        $this->map = new Map($mapOptions);

        $this->map->appendScript('var bounds = new google.maps.LatLngBounds();');
        foreach ($model->markers as $marker) {
            $markers = new Marker([
                'position' => new LatLng($marker->getCoords()),
                'title' => $marker->name,
                'opacity' => $marker->opacity
            ]);
            if ($marker->content_body) {
                $markers->attachInfoWindow(
                    new InfoWindow([
                        'content' => $marker->content_body
                    ])
                );
            }

            $this->map->addOverlay($markers);
            $this->map->appendScript('bounds.extend(new google.maps.LatLng(' . $marker->getCoords()->lat . ',' . $marker->getCoords()->lng . '));');
        }

        $this->map->appendScript($this->map->getName().".fitBounds(bounds);");
    }

    public function run()
    {
        echo $this->map->display();
    }

}
