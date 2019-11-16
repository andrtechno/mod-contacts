<?php

namespace panix\mod\contacts\widgets\map;

use panix\mod\contacts\models\Markers;
use Yii;
use panix\lib\google\maps\LatLng;
use panix\lib\google\maps\overlays\InfoWindow;
use panix\lib\google\maps\overlays\Marker;
use panix\lib\google\maps\Map;
use panix\lib\google\maps\MapAsset;
use panix\mod\contacts\models\Maps;
use panix\engine\data\Widget;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * Description of Map
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */
class MapWidget extends Widget
{

    /**
     * @var Map
     */
    private $map;
    public $map_id;
    public $options = [];
    private $model;
    public static $autoIdPrefix = '';

    public function init()
    {
        parent::init();
        $view = Yii::$app->getView();

        $this->model = Maps::findOne($this->map_id);

        Yii::$app->assetManager->bundles['panix\lib\google\maps\MapAsset'] = [
            'options' => [
                'key' => $this->model->api_key
            ]
        ];
        MapAsset::register($view);

        if ($this->model) {

            $mapOptions = ArrayHelper::merge([
                'center' => new LatLng($this->model->getCenter()),
                'zoom' => $this->model->zoom,
                'width' => $this->model->width,
                'height' => $this->model->height,
            ], $this->options);

            $this->map = new Map($mapOptions);

            $this->initMarkers();

        } else {
            $this->map = false;
        }
    }

    public function run()
    {
        if ($this->map) {
            echo $this->map->display();
        }
    }


    private function initMarkers()
    {
        if ($this->model->boundMarkers)
            $this->map->appendScript('var bounds = new google.maps.LatLngBounds();');

        foreach ($this->model->markers as $marker) {
            /** @var Markers $marker */
            $position = new LatLng($marker->getCoords());
            $markers = new Marker([
                'position' => $position,
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
            if ($this->model->boundMarkers)
                $this->map->appendScript('bounds.extend(' . $position->getJs() . ');');
        }
        if ($this->model->markersCount > 1 && $this->model->boundMarkers)
            $this->map->appendScript($this->map->getName() . ".fitBounds(bounds);");
    }

}
