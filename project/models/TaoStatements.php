<?php

namespace project\models;

use Yii;

/**
 * This is the model class for table "statements".
 *
 * @property int $id
 * @property int $modelid
 * @property string $subject
 * @property string $predicate
 * @property string|null $object
 * @property string|null $l_language
 * @property string|null $author
 * @property string|null $epoch
 */
class TaoStatements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statements';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('taodb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modelid'], 'integer'],
            [['subject', 'predicate'], 'required'],
            [['object'], 'string'],
            [['subject', 'predicate', 'l_language', 'author', 'epoch'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'modelid' => Yii::t('app', 'Modelid'),
            'subject' => Yii::t('app', 'Subject'),
            'predicate' => Yii::t('app', 'Predicate'),
            'object' => Yii::t('app', 'Object'),
            'l_language' => Yii::t('app', 'L Language'),
            'author' => Yii::t('app', 'Author'),
            'epoch' => Yii::t('app', 'Epoch'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TaoStatementsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaoStatementsQuery(get_called_class());
    }
}
