<?php

namespace domain\mysql\queries;
use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\domain\mysql\Category]].
 *
 * @see \domain\mysql\Category
 */
class CategoryQuery extends ActiveQuery
{

    use NestedSetsQueryTrait;
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \domain\mysql\Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \domain\mysql\Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
