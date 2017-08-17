<?php

namespace panix\mod\contacts\models;

use yii\db\ActiveQuery;

class MarkersQuery extends ActiveQuery {

    public function getCoords2() {
        $this->addSelect([
            "*",
            new \yii\db\Expression("CONCAT(X(coords),',',Y(coords)) AS coords")]
            );
         return $this;
    }
    
    public function getCoords() {
        $this->addSelect(["coords"=>new \yii\db\Expression("CONCAT(X(coords),',',Y(coords))")]);
         return $this;
    }



}
