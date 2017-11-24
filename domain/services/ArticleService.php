<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/24/17
 * Time: 8:24 AM
 */

namespace domain\services;


use domain\entities\Article;
use domain\formaters\IArticleFormatter;
use domain\repositories\MySqlArticleRepository;
use DomainException;
use yii\web\NotFoundHttpException;

class ArticleService
{
    private $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new MySqlArticleRepository();
    }

    /* @param $article Article
     * @throws \RuntimeException
     * @return int
     */
    public function save(Article $article)
    {
        if($this->validate($article))
            return $this->articleRepository->save($article);

        return false;
    }

    /* @return \domain\entities\Article[]*/
    public function getAll(): array
    {
        return $this->articleRepository->getAll();
    }

    /* @param $articles \domain\entities\Article[]
     * @param $articleFormatter
     * @return mixed
     * */
    public function format(IArticleFormatter $articleFormatter, array $articles)
    {
        return $articleFormatter->format($articles);
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function getOne($id): Article
    {
        return $this->articleRepository->get($id);
    }

    /* @param $id int
     * @throws DomainException
     * @return bool
     * */
    public function delete($id)
    {
        if(!is_int($id))
            throw new DomainException('Impossible to delete category with such id');

        return $this->articleRepository->delete($id);
    }

    public function validate(Article $article)
    {
        if(!$article->validate() || !$article->getMeta()->validate()) {
            return false;
        }

        return true;
    }
}