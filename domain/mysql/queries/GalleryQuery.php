<?php

namespace domain\mysql\queries;

/**
 * This is the ActiveQuery class for [[\domain\mysql\Gallery]].
 *
 * @see \domain\mysql\Gallery
 */
class GalleryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \domain\mysql\Gallery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \domain\mysql\Gallery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
