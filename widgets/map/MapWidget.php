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
    public static $autoIdPrefix = '';

    public function init() {
        parent::init();

        $model = $this->findModel($this->map_id);

        $mapOptions = [
            'center' => new LatLng($model->getCenter()),
            'zoom' => $model->zoom,
        ];


        $this->map = new Map($mapOptions);
        if ($model->grayscale) {
            $this->getGrayscaleJs();
        }
        if ($model->night_mode) {
            $hour = date("H");
            if ($hour >= 22 or $hour < 04) {
                $this->getNightModeJs();
            }
        }





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
        $this->map->appendScript("gmap{$this->id}.fitBounds(bounds);");
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

    private function getNightModeJs() {
        $this->map->appendScript("
                    gmap{$this->id}.setOptions({
            styles: [
                {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
                {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
                {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
                {
                    featureType: 'administrative.locality',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#d59563'}]
                },
                {
                    featureType: 'poi',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#d59563'}]
                },
                {
                    featureType: 'poi.park',
                    elementType: 'geometry',
                    stylers: [{color: '#263c3f'}]
                },
                {
                    featureType: 'poi.park',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#6b9a76'}]
                },
                {
                    featureType: 'road',
                    elementType: 'geometry',
                    stylers: [{color: '#38414e'}]
                },
                {
                    featureType: 'road',
                    elementType: 'geometry.stroke',
                    stylers: [{color: '#212a37'}]
                },
                {
                    featureType: 'road',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#9ca5b3'}]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'geometry',
                    stylers: [{color: '#746855'}]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'geometry.stroke',
                    stylers: [{color: '#1f2835'}]
                },
                {
                    featureType: 'road.highway',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#f3d19c'}]
                },
                {
                    featureType: 'transit',
                    elementType: 'geometry',
                    stylers: [{color: '#2f3948'}]
                },
                {
                    featureType: 'transit.station',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#d59563'}]
                },
                {
                    featureType: 'water',
                    elementType: 'geometry',
                    stylers: [{color: '#17263c'}]
                },
                {
                    featureType: 'water',
                    elementType: 'labels.text.fill',
                    stylers: [{color: '#515c6d'}]
                },
                {
                    featureType: 'water',
                    elementType: 'labels.text.stroke',
                    stylers: [{color: '#17263c'}]
                }
            ]

        });
                        ");
    }

    private function getGrayscaleJs() {
           $this->map->appendScript("gmap{$this->id}.setMapTypeId('roadmap');");
    //terrain
        //gmap.setMapTypeId('hybrid');
        // gmap.setMapTypeId('roadmap');
        $this->map->appendScript("
gmap{$this->id}.setOptions({
      styles: [
        {'featureType':'landscape','stylers':[
            {'saturation':-100},
            {'lightness':20},
            {'visibility':'on'}
        ]},{
        'featureType':'poi',
        'stylers':[
            {'saturation':-100},
            {'lightness':25},
            {'visibility':'simplified'}
        ]},{
        'featureType':'road.highway',
        'stylers':[
            {'saturation':-100},
            {'visibility':'simplified'}
        ]},{
        'featureType':'road.arterial',
        'stylers':[
            {'saturation':-100},
            {'lightness':20},
            {'visibility':'on'}
        ]},{
        'featureType':'road.local',
        'stylers':[{
            'saturation':-100},
            {'lightness':30},
            {'visibility':'on'}
        ]},{
        'featureType':'transit',
        'stylers':[
            {'saturation':-100},
            {'visibility':'simplified'}
        ]},{
        'featureType':'administrative.province',
        'stylers':[{
            'visibility':'off'
        }]},{
        'featureType':'water',
        'elementType':'labels',
        'stylers':[{
            'visibility':'on'},
            {'ightness':-25},
            {'saturation':-100}
        ]},{
        'featureType':'water',
        'elementType':'geometry',
        'stylers':[{
            'hue':'#ffff00'
        },{
            'lightness':-25
        },{
            'saturation':-97
        }]}]
});
    ");
    }

}
