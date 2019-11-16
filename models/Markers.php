<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\mod\contacts\models\MarkersQuery;
use panix\mod\contacts\models\Maps;
use panix\engine\db\ActiveRecord;

/**
 * Class Markers
 *
 * @property integer $id
 * @property integer $map_id
 * @property float $opacity
 * @property string $name
 * @property string $content_body
 *
 * @package panix\mod\contacts\models
 */
class Markers extends ActiveRecord {

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
            [['name', 'map_id', 'coords', 'opacity'], 'required'],
            [['coords'], 'trim'],
            [['name'], 'string', 'max' => 255],
            [['content_body'], 'string'],
            [['opacity'], 'number'],
        ];
    }

    public function getMap() {
        return $this->hasOne(Maps::class, ['id' => 'map_id']);
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
       //$this->coords = $this->find()->addSelect(['coords'=>new \yii\db\Expression("CONCAT(X(coords),',',Y(coords))")]);
      // $this->coords = $this->find()->addSelect(['coords'=>new \yii\db\Expression("CONCAT(X(coords),',',Y(coords))")]);

       // $this->coords =$this->find()->getCoords2();
        parent::afterFind();
    }

    public function getCoords() {
        $toArray = explode(',', $this->coords);
        return (object) ['lat' => $toArray[0], 'lng' => $toArray[1]];
    }

    public function getOpacityList() {
        return [
            '0.1' => '10%',
            '0.2' => '20%',
            '0.3' => '30%',
            '0.4' => '40%',
            '0.5' => '50%',
            '0.6' => '60%',
            '0.7' => '70%',
            '0.8' => '80%',
            '0.9' => '90%',
            '1' => '100%'];
    }

}
