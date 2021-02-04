<?php

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190330_104130_contacts_map_markers
 */

use panix\engine\db\Migration;
use panix\mod\contacts\models\Markers;

class m190330_104130_contacts_map_markers extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable(Markers::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'map_id' => $this->string(255)->null(),
            'coords' => 'POINT',
            'name' => $this->text()->null(),
            'draggable' => $this->boolean()->notNull()->defaultValue(0),
            'animation'=>$this->string(100)->null(),
            'icon_file' => $this->string(255)->null(),
            'icon_file_offset_x' => $this->string(5)->null(),
            'icon_file_offset_y' => $this->string(5)->null(),
            'icon_content' => $this->string(255)->null(),
            'hint_content' => $this->string(255)->null(),
            'content_body' => $this->text()->null(),
            'content_footer' => $this->string(255)->null(),
            'opacity' => $this->float(255)->defaultValue(1),

        ], $this->tableOptions);
        $this->createIndex('map_id', Markers::tableName(), 'map_id');
    }

    public function down()
    {
        echo "m190330_104130_contacts_map_markers cannot be reverted.\n";
        $this->dropTable(Markers::tableName());
        return false;
    }

}
