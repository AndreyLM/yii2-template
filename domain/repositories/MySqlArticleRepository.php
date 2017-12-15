<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/20/17
 * Time: 2:07 PM
 */

namespace domain\repositories;


use domain\entities\Article;
use domain\mysql\Article as ARArticle;
use domain\exceptions\DomainException;
use yii\web\NotFoundHttpException;

class MySqlArticleRepository implements IArticleRepository
{

    /* @param $id int
     * @throws \RuntimeException
     * @return bool
     * */
    public function delete($id)
    {
        $arArticle = $this->find($id);
        if(!$arArticle->delete())
            throw new \RuntimeException('Removing error');

        return true;
    }

    /* @param $article Article
     * @throws \RuntimeException
     * @return int
     */
    public function save(Article $article)
    {
        $article->id ?
            $arArticle = $this->find($article->id) :
            $arArticle = new ARArticle();

        $this->mapToActiveRecord($article, $arArticle);

        if(!$arArticle->save())
            throw new \RuntimeException('Cannot save article');

        return $arArticle->id;
    }

    /* @param $id int
     * @throws NotFoundHttpException
     * @return Article
     */
    public function get(int $id): Article
    {
        $arArticle = $this->find($id);

        $article = new Article();
        $this->mapToEntity($arArticle, $article);

        return $article;
    }

    /* @throws NotFoundHttpException
     * @return \domain\entities\Category[]
     */
    public function getAll(): array
    {
        $articles = [];
        $arArticles = ARArticle::find()->all();

        foreach ($arArticles as $arCategory) {
            $article = new Article();
            $this->mapToEntity($arCategory, $article);
            $articles[] = $article;
        }

        return $articles;
    }

    private function find($id)
    {
        if(!$arArticle = ARArticle::findOne($id)) {
            throw new NotFoundHttpException('Article is not found');
        }

        return $arArticle;
    }


    private function mapToEntity(ARArticle $arArticle, Article $article)
    {
        $article->id = $arArticle->id;
        $article->title = $arArticle->title;
        $article->slug = $arArticle->slug;
        $article->categoryId = $arArticle->category_id;
        $article->author = $arArticle->author;
        $article->userId = $arArticle->user_id;

        $article->textIntro = $arArticle->text_intro;
        $article->textBody = $arArticle->text_body;
        $article->textBodyMarkdown = $arArticle->text_body_markdown;

        $article->status = $arArticle->status;
        $article->favorite = $arArticle->favorite;
        $article->setMeta($arArticle->meta);

        $article->createdAt = $arArticle->created_at;
        $article->updatedAt = $arArticle->updated_at;
        $article->publishingAt = $arArticle->publishing_at;

    }

    private function mapToActiveRecord(Article $article, ARArticle $arArticle)
    {
        $arArticle->id = $article->id;
        $arArticle->title = $article->title;
        $arArticle->slug = $article->slug;

        $arArticle->category_id = $article->categoryId;
        $arArticle->author = $article->author;
        $article->userId ? $arArticle->user_id = $article->userId :
            $arArticle->user_id = \Yii::$app->user->id;


        $arArticle->text_intro = $article->textIntro;
        $arArticle->text_body = $article->textBody;

        $arArticle->text_body_markdown = $article->textBodyMarkdown;

        $arArticle->status = $article->status;
        $arArticle->favorite = $article->favorite;
        $arArticle->meta = $article->getMeta();

        $arArticle->created_at = $article->createdAt;
        $arArticle->updated_at = $article->updatedAt;
        $arArticle->publishing_at = $article->publishingAt;
    }

    /* @param $categoryId int
     * @return array | null
     */
    public function getByCategoryId($categoryId)
    {
        $articles = [];
        $arArticles = ARArticle::find()->where(['category_id' => $categoryId])->all();

        foreach ($arArticles as $arCategory) {
            $article = new Article();
            $this->mapToEntity($arCategory, $article);
            $articles[] = $article;
        }

        return $articles;
    }
}