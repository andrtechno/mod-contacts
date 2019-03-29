<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\engine\db\ActiveRecord;


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
            [['name', 'zoom', 'height', 'width', 'center'], 'required'],
            [['name', 'center'], 'string', 'max' => 255],
            ['zoom', 'in', 'range' => $this->getZoomList()],
            //['center', 'validateLatLng'],

            [['night_mode', 'grayscale'], 'boolean'],

        ];
    }

    public function validateLatLng($attribute)
    {
        list($lat,$lng) = explode(',',$this->{$attribute});
        $this->addError($attribute,'err');
    }

    public function getMarkers()
    {
        return $this->hasMany(Markers::class, ['map_id' => 'id']);
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
        return (object)['lat' => $toArray[0], 'lng' => $toArray[1]];
    }

    public function getZoomList()
    {
        return range(1, 20);
    }


}
