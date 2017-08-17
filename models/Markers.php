<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\engine\WebModel;
use panix\mod\contacts\models\MarkersQuery;

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
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function beforeSave($insert) {
        $coord = explode(',', $this->coords);
        $this->coords = new \yii\db\Expression("GeomFromText(:point)", array(':point' => 'POINT(' . $coord[0] . ' ' . $coord[1] . ')'));
        if (empty($this->icon_file)) {
            $this->icon_file = new \yii\db\Expression('NULL');
        }
        return parent::beforeSave($insert);
    }

    public function afterFind() {
        $query = new \yii\db\Query();
        $query->addSelect(['coords' => new \yii\db\Expression("CONCAT(X(coords),',',Y(coords))")]);
        $query->from(self::tableName());

        $result = $query->one();

        //$test = $this->find()->addSelect(['*', 'coords' => new \yii\db\Expression("CONCAT(X(coords),',',Y(coords))")]);
//print_r($test);
//die;
        $this->coords = $result['coords'];
        parent::afterFind();
    }

}
