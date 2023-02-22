<?php

namespace backend\models\forms;

use common\components\traits\ColorTrait;

/**
 * AppleForm model
 *
 * @property string $color
 */
class AppleForm extends \yii\base\Model
{

    use ColorTrait;

    public string $color = '';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['color', 'string'],
        ];
    }
}