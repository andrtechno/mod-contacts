<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\engine\WebModel;
use panix\mod\contacts\models\MarkersQuery;
use panix\mod\contacts\models\Maps;

class Markers extends WebModel {

    const MODULE_ID = 'contacts';

    public static function find() {
        return new MarkersQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%contacts_map_markers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'map_id', 'coords'], 'required'],
            [['coords'], 'trim'],
            [['name'], 'string', 'max' => 255]
        ];
    }
    public function getMap() {
        return $this->hasOne(Maps::className(), ['id' => 'map_id']);
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $coord = explode(',', $this->coords);

            $this->coords = new \yii\db\Expression("GeomFromText(:point)", array(':point' => 'POINT(' . $coord[0] . ' ' . $coord[1] . ')'));
            if (empty($this->icon_file)) {
                $this->icon_file = new \yii\db\Expression('NULL');
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterFind() {
        $query = new \yii\db\Query();
        $query->addSelect(['coords' => new \yii\db\Expression("CONCAT(X(coords),',',Y(coords))")]);

        $query->from(self::tableName());
        $query->where('id=:id', ['id' => $this->id]);
        $result = $query->one();

        $this->coords = $result['coords'];
        parent::afterFind();
    }

    public function getCoords() {
        $toArray = explode(',', $this->coords);
        return (object) ['lat' => $toArray[0], 'lng' => $toArray[1]];
    }


}
