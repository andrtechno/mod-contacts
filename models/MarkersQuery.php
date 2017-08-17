<?php

namespace panix\mod\contacts\models;

use yii\db\ActiveQuery;

class MarkersQuery extends ActiveQuery {

    public function coords() {
        $this->addSelect([
            "*",
            new \yii\db\Expression("CONCAT(X(coords),',',Y(coords)) AS coords")]
            );
         return $this;
    }


}
