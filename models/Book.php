<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $release_year
 * @property int|null $isbn
 * @property string|null $created_at
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 * @property BookImage[] $bookImages
 */
class Book extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'release_year'], 'required'],
            [['description'], 'string'],
            [['release_year', 'isbn'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'release_year' => 'Release Year',
            'isbn' => 'Isbn',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookImages]].
     *
     * @return ActiveQuery
     */
    public function getBookImages()
    {
        return $this->hasMany(BookImage::class, ['book_id' => 'id']);
    }
}
