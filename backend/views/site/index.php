<?php

/** @var yii\web\View $this */
/** @var \backend\models\forms\AppleForm $appleFormModel */
/** @var \yii\data\ActiveDataProvider $dataProvider */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>


    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Добавить яблоко</h2>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($appleFormModel, 'color') ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить яблоко', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <hr />

                <div class="form-group">
                    <?= Html::a('Сгенерировать яблок', ['site/apple-generate'], ['class'=>'pay btn btn-primary','data-pjax' => '0']); ?>
                </div>

                <hr />

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{eat-quarter}<br/><br/>{eat-half}<br/><br/>{fall}<br/><br/>{delete}',  // the default buttons + your custom button
                            'buttons' => [
                                'eat-quarter' => function($url, $model, $key) {     // render your custom button
                                    return Html::a('Съесть четверть', $url, ['class'=>'pay btn btn-primary','data-pjax' => '0']);
                                },
                                'eat-half' => function($url, $model, $key) {     // render your custom button
                                    return Html::a('Съесть половину', $url, ['class'=>'pay btn btn-primary','data-pjax' => '0']);
                                },
                                'fall' => function($url, $model, $key) {     // render your custom button
                                    return Html::a('Упасть', $url,['class'=>'pay btn btn-primary','data-pjax' => '0']);
                                },
                                'delete' => function($url, $model, $key) {     // render your custom button
                                    return Html::a('Доесть', $url,['class'=>'pay btn btn-primary','data-pjax' => '0']);
                                }
                            ]
                        ],
                        'id',
                        'color',
                        'appearance_date',
                        'fall_date',
                        [                                                  // the owner name of the model
                            'label' => 'Испорчено?',
                            'value'  => function ($model) {
                                return $model->getRotStatus() ? 'Да' : 'Нет';
                            },
                        ],
                        [                                                  // the owner name of the model
                            'label' => 'Процент съеденного',
                            'value'  => function ($model) {
                                return (1 - $model->size) * 100;
                            },
                        ],
                    ],
                ]) ?>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
