<?php
/**
 * author E.Demidov 2024
 */

namespace app\models;

use yii\db\Exception;
use yii\web\UploadedFile;

class BookForm extends Book
{
    /** @var int[] */
    public array $bookAuthors = [];

    /** @var UploadedFile */
    public $imageFile;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['bookAuthors', 'required'],
            ['bookAuthors', 'each', 'rule' => ['integer', 'message' => 'The authors are invalid']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ]);
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::rules(), ['bookAuthors' => 'Author']);
    }

    public function save($runValidation = true, $attributeNames = null): bool
    {
        if ($this->validate()) {

            parent::save($runValidation, $attributeNames);

            $this->saveAuthor();
            $this->saveImage();

            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function saveAuthor()
    {
        BookAuthor::deleteAll(['book_id' => $this->id]);
        foreach ($this->bookAuthors as $author) {
            $record = new BookAuthor();
            $record->book_id = $this->id;
            $record->author_id = $author;
            $record->save();
        }
    }

    /**
     * @throws Exception
     */
    public function saveImage(): bool
    {
        $imageFile = UploadedFile::getInstance($this, 'imageFile');

        if (!$imageFile) {
            return true;
        }

        $filename = uniqid('book_') . '.' . $imageFile->extension;

        if ($imageFile->saveAs('uploads/' . $filename)) {
            $image = BookImage::findOne(['book_id' => $this->id]) ?? new BookImage();
            $image->book_id = $this->id;
            $image->filename = $filename;
            $image->cover = 1;
            return $image->save();
        }

        return false;
    }
}
