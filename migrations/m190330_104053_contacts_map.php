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


        if($this->db->driverName == 'pgsql'){
            $this->execute('DROP TYPE IF EXISTS typeMapEnum');
            $this->execute("CREATE TYPE typeMapEnum AS ".$this->enum(['roadmap', 'satellite', 'hybrid', 'terrain']).""); // DEFAULT 'roadmap'
            $type = 'typeMapEnum';
        }else{
            $type = $this->enum(['roadmap', 'satellite', 'hybrid', 'terrain'])." NOT NULL DEFAULT 'roadmap'";
        }

        $this->createTable(Maps::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'api_key' => $this->string(255),
            'boundMarkers'=>$this->boolean()->defaultValue(true),
            'name' => $this->string(255),
            'zoom' => $this->smallInteger()->unsigned()->defaultValue(13),
            'height' => $this->string(5),
            'width' => $this->string(5),
            'center' => 'point',
            'type' => $type,
            'drag' => $this->boolean()->defaultValue(true),
            'scrollwheel' => $this->boolean()->notNull()->defaultValue(true),
            'transitLayer' => $this->boolean()->notNull()->defaultValue(false),
            'bikeLayer' => $this->boolean()->notNull()->defaultValue(false),
            'trafficLayer' => $this->boolean()->notNull()->defaultValue(false),
            'fullscreenControl' => $this->boolean()->defaultValue(false),
            'streetViewControl' => $this->boolean()->defaultValue(false),
            'mapTypeControl' => $this->boolean()->defaultValue(false),
            'zoomControl' => $this->boolean()->defaultValue(false),
            'scaleControl' => $this->boolean()->defaultValue(false),
            'rotateControl' => $this->boolean()->defaultValue(false),
            'auto_show_routers' => $this->boolean()->defaultValue(false),
        ], $this->tableOptions);
        $this->loadSettings();
    }

    public function down()
    {
        if($this->db->driverName == 'pgsql'){
            $this->execute('DROP TYPE typeMapEnum');
        }
        $this->dropTable(Maps::tableName());
    }

}
