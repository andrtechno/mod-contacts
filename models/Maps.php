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
class Maps extends WebModel {
    const MODULE_ID = 'contacts';
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%contacts_maps}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name','zoom','height','width'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

 




}
