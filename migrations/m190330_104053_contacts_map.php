<?php

namespace panix\mod\contacts\migrations;

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190330_104053_contacts_map
 */

use panix\engine\components\Settings;
use panix\engine\db\Migration;
use panix\mod\contacts\models\Maps;
use panix\mod\contacts\models\SettingsForm;

class m190330_104053_contacts_map extends Migration
{

    public function up()
    {
        $this->createTable(Maps::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->notNull(),
            'zoom' => $this->smallInteger()->unsigned(),
            'height' => $this->string(5)->notNull(),
            'width' => $this->string(5)->notNull(),
            'center' => 'point',
            'type' => "ENUM('roadmap', 'satellite', 'hybrid', 'terrain')",
            'drag' => $this->boolean()->notNull(),
            'scrollwheel' => $this->boolean()->notNull(),
            'transitLayer' => $this->boolean()->notNull(),
            'trafficLayer' => $this->boolean()->notNull(),
            'fullscreenControl' => $this->boolean()->notNull(),
            'streetViewControl' => $this->boolean()->notNull(),
            'mapTypeControl' => $this->boolean()->notNull(),
            'zoomControl' => $this->boolean()->notNull(),
            'scaleControl' => $this->boolean()->notNull(),
            'rotateControl' => $this->boolean()->notNull(),
            'auto_show_routers' => $this->boolean()->notNull(),
        ], $this->tableOptions);


        $settings = [];
        foreach (SettingsForm::defaultSettings() as $key => $value) {
            $settings[] = [SettingsForm::$category, $key, $value];
        }

        $this->batchInsert(Settings::tableName(), ['category', 'param', 'value'], $settings);
    }

    public function down()
    {
        $this->dropTable(Maps::tableName());
    }

}
