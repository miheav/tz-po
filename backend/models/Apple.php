<?php

namespace backend\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\components\traits\ColorTrait;

/**
 * Apple model
 *
 * @property integer $id
 * @property string $color
 * @property integer $appearance_date
 * @property integer $fall_date
 * @property integer $status
 * @property integer $bad
 * @property float $size
 * @property integer $created_at
 * @property integer $updated_at
 */
class Apple extends ActiveRecord
{

    use ColorTrait;

    const STATUS_ON_TREE = 0;
    const STATUS_FALL = 1;


    function __construct($color = false)
    {
        parent::__construct();

        if(!$color) {
            $color = self::getRandomColor();
        }

        $this->color = $color;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ON_TREE],
            ['status', 'in', 'range' => [self::STATUS_ON_TREE, self::STATUS_FALL]],
            [['status', 'bad'], 'integer'],
            [['color', 'appearance_date', 'fall_date'], 'string'],
            ['size', 'double']
        ];
    }


    public function attributeLabels()
    {
        return [
            'status' => 'Статус',
            'bad' => 'Гнилое?',
            'appearance_date' => 'Дата поедания',
            'fall_date' => 'Дата падения с дерева',
            'color' => 'Цвет',
            'size' => 'Процент съеденного',
        ];
    }

    public function eat($percent)
    {

        if(!$this->fall_date) {
            throw new \yii\base\Exception( "Яблоко на дереве, его нельзя съесть" );
        } elseif ($this->getRotStatus()) {
            throw new \yii\base\Exception( "Яблоко сгнило, его нельзя съесть" );
        }

        $this->size -= $percent;

    }

    public function getRotStatus()
    {
        return strtotime($this->fall_date ?? 'now') + 60 * 60 * 5 < strtotime('now') ;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
}
