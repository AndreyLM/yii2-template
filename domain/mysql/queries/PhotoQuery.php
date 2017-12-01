<?php

namespace domain\mysql\queries;

/**
 * This is the ActiveQuery class for [[\domain\mysql\Photo]].
 *
 * @see \domain\mysql\Photo
 */
class PhotoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \domain\mysql\Photo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \domain\mysql\Photo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
