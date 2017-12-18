<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 4:14 PM
 */

namespace domain\services;


use domain\entities\Category;
use domain\exceptions\DomainException;
use domain\formaters\ICategoryFormatter;
use domain\repositories\ICategoryRepository;
use domain\repositories\MySqlCategoryRepository;
use yii\web\NotFoundHttpException;

class CategoryService implements ICategoryService
{
    private $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /* @param $category Category
     * @throws DomainException
     *  @return int
     */
    public function save(Category $category)
    {
        if($this->validate($category))
            return $this->categoryRepository->save($category);
        return false;
    }

    /* @return \domain\entities\Category[]*/
    public function getAll(): array
    {
        return $this->categoryRepository->getAll();
    }

    /* @param $categories \domain\entities\Category[]
     * @param $categoryFormatter
     * @return mixed
     * */
    public function format(ICategoryFormatter $categoryFormatter, array $categories)
    {
        return $categoryFormatter->format($categories);
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Category
     */
    public function getOne($id): Category
    {
        return $this->categoryRepository->get($id);
    }

    /* @param $id int
     * @throws DomainException
     * @return bool
     * */
    public function delete($id)
    {
        if($id==1)
            throw new DomainException('Impossible to delete category with such id');

        return $this->categoryRepository->delete($id);
    }

    public function validate(Category $category)
    {
        if(!$category->validate() || !$category->getMeta()->validate()) {
            return false;
        }

        return true;
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return array Category[]
     */
    public function getOneWithChildren($id)
    {
        return $this->categoryRepository->getOneWithChildren($id);
    }
}