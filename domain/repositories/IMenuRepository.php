<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:08 PM
 */

namespace domain\repositories;


interface IMenuRepository
{
    /* @param $id int
     * @throws \RuntimeException
     * @return bool
     * */
    public function delete($id);

    /* @param $category Category
     * @throws DomainException
     *  @return int
     */
    public function save( $category);

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Category
     */
    public function get(int $id):Category;

    /* @throws NotFoundHttpException
     * @return \domain\entities\Category[]
     */
    public function getAll():array;
}