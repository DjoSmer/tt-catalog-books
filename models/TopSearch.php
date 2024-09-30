<?php
/**
 * author E.Demidov 2024
 */

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


class TopSearch extends Model
{
    public int $release_year;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['release_year'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'release_year' => 'Release Year',
            'number' => 'Number of books',
        ];
    }

    /**
     * Top 10 of authors who have published more books in a year
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function top10(array $params): ActiveDataProvider
    {
        $query = Book::find()
            ->select(['author.*', 'count(book_id) as number'])
            ->innerJoinWith('authors')
            ->groupBy(['author_id'])
            ->limit(10)
            ->asArray();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'release_year' => $this->release_year,
        ]);

        return $dataProvider;
    }
}
