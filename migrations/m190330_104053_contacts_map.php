<?php

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190330_104053_contacts_map
 */

use panix\engine\db\Migration;
use panix\mod\contacts\models\Maps;

class m190330_104053_contacts_map extends Migration
{
    public $settingsForm = 'panix\mod\contacts\models\SettingsForm';

    public function up()
    {
        $this->createTable(Maps::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'api_key' => $this->string(255),
            'boundMarkers'=>$this->boolean()->defaultValue(1),
            'name' => $this->string(255),
            'zoom' => $this->smallInteger()->unsigned()->defaultValue(13),
            'height' => $this->string(5),
            'width' => $this->string(5),
            'center' => 'point',
            'type' => "ENUM('roadmap', 'satellite', 'hybrid', 'terrain') NOT NULL DEFAULT 'roadmap'",
            'drag' => $this->boolean()->defaultValue(1),
            'scrollwheel' => $this->boolean()->notNull()->defaultValue(1),
            'transitLayer' => $this->boolean()->notNull()->defaultValue(0),
            'bikeLayer' => $this->boolean()->notNull()->defaultValue(0),
            'trafficLayer' => $this->boolean()->notNull()->defaultValue(0),
            'fullscreenControl' => $this->boolean()->defaultValue(0),
            'streetViewControl' => $this->boolean()->defaultValue(0),
            'mapTypeControl' => $this->boolean()->defaultValue(0),
            'zoomControl' => $this->boolean()->defaultValue(0),
            'scaleControl' => $this->boolean()->defaultValue(0),
            'rotateControl' => $this->boolean()->defaultValue(0),
            'auto_show_routers' => $this->boolean()->defaultValue(0),
        ], $this->tableOptions);
        $this->loadSettings();
    }

    public function down()
    {
        $this->dropTable(Maps::tableName());
    }

}
