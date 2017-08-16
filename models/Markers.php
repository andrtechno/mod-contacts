<?php

namespace panix\mod\contacts\models;

use Yii;
use panix\engine\WebModel;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $name
 */
class Markers extends WebModel {
    const MODULE_ID = 'contacts';
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

  /*  protected function beforeFind() {
        parent::beforeFind();
        $alias = $this->getTableAlias(true);
        $criteria = new CDbCriteria;
        $criteria->select = array(
            "*",
            new CDbExpression("CONCAT(X({$alias}.`coords`),',',Y({$alias}.`coords`)) AS coords"),
        );
        $this->dbCriteria->mergeWith($criteria);
    }
*/
}
