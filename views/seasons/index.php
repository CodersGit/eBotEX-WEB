<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SeasonsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Seasons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasons-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a(Yii::t('app', 'Create Seasons'), ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?php Pjax::begin(); ?>            <?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'name',
			'event',
			'start',
			'end',
			// 'link',
			// 'logo',
			// 'active',
			// 'created_at',
			// 'updated_at',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
	<?php Pjax::end(); ?></div>
