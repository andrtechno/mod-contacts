<?php

namespace panix\mod\contacts\widgets\map;

use Yii;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;

/**
 * Description of Map
 *
 * @author CORNER CMS development team <dev@corner-cms.com>
 */
class MapWidget extends \yii\base\Widget {

    private $map;
    public $map_id;

    public function init() {
        parent::init();

        $model = $this->findModel($this->map_id);
        $this->map = new Map([
            'center' => new LatLng($model->getCenter()),
            'zoom' => $model->zoom,
        ]);
        foreach ($model->markers as $marker) {
            $markers = new Marker([
                'position' => new LatLng($marker->getCoords()),
                'title' => 'My Home Town',
            ]);
            $markers->attachInfoWindow(
                    new InfoWindow([
                'content' => $marker->name
                    ])
            );
            $this->map->addOverlay($markers);
 
        }
    //    print_r($this->map->getBoundsFromCenterAndZoom());


    }

    public function run() {
        echo $this->map->display();
    }

    protected function findModel($id) {
        $model = Yii::$app->getModule("contacts")->model("Maps");
        if (($model = $model::find(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app/error', '404'));
        }
    }

}
