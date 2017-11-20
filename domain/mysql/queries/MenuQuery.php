<?php

namespace domain\mysql\queries;

/**
 * This is the ActiveQuery class for [[\domain\mysql\Menu]].
 *
 * @see \domain\mysql\Menu
 */
class MenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \domain\mysql\Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \domain\mysql\Menu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
