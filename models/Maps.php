<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\engine\db\ActiveRecord;

/**
 * Class Maps
 *
 * @property integer $id
 * @property string $api_key API key google map
 * @property string $name
 * @property integer $zoom
 * @property string $width
 * @property string $height
 * @property string $center
 * @property string $type
 * @property boolean $drag
 * @property boolean $scrollwheel
 * @property boolean $transitLayer
 * @property boolean $trafficLayer
 * @property boolean $fullscreenControl
 * @property boolean $streetViewControl
 * @property boolean $mapTypeControl
 * @property boolean $zoomControl
 * @property boolean $scaleControl
 * @property boolean $rotateControl
 * @property boolean $auto_show_routers
 * @property boolean $boundMarkers
 *
 * @property Markers[] $markers
 * @property Markers $markersCount Count
 *
 * @package panix\mod\contacts\models
 */
class Maps extends ActiveRecord
{
    const MODULE_ID = 'contacts';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contacts_maps}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zoom', 'height', 'width', 'center', 'api_key'], 'required'],
            [['name', 'center'], 'string', 'max' => 255],
            [['boundMarkers'], 'boolean'],
            ['zoom', 'in', 'range' => $this->getZoomList()],
            //['center', 'validateLatLng'],


        ];
    }

    public function validateLatLng($attribute)
    {
        list($lat, $lng) = explode(',', $this->{$attribute});
        $this->addError($attribute, 'err');
    }

    public function getMarkers()
    {
        return $this->hasMany(Markers::class, ['map_id' => 'id']);
    }
    public function getMarkersCount()
    {
        return $this->hasMany(Markers::class, ['map_id' => 'id'])->count();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $coord = explode(',', $this->center);
            $this->center = new \yii\db\Expression("GeomFromText(:point)", array(':point' => 'POINT(' . $coord[0] . ' ' . $coord[1] . ')'));
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        $query = new \yii\db\Query();
        $query->addSelect(['center' => new \yii\db\Expression("CONCAT(X(center),',',Y(center))")]);

        $query->from(self::tableName());
        $query->where('id=:id', ['id' => $this->id]);
        $result = $query->one();

        $this->center = $result['center'];
        parent::afterFind();
    }

    public function getCenter()
    {

        $toArray = explode(',', $this->center);
        return ['lat' => $toArray[0], 'lng' => $toArray[1]];
    }

    public function getZoomList()
    {
        return array_combine(range(1, 20), range(1, 20));
    }


}
