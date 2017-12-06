<?php

	namespace app\controllers;

	use Yii;
	use app\models\Stats\Players;
	use app\models\Users\Users;
	use app\models\Users\User;
	use app\models\Stats\PlayersSearch;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\web\Response;

	/**
	 * PlayersController implements the CRUD actions for Players model.
	 */
	class PlayersController extends Controller {
		/**
		 * @inheritdoc
		 */
		public function behaviors () {
			return [
				'verbs' => [
					'class'   => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			];
		}

		/**
		 * Lists all Players models.
		 *
		 * @return mixed
		 */
		public function actionIndex () {
			$searchModel = new PlayersSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'searchModel'  => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}

		/**
		 * Get JSON of player.
		 *
		 * @param $steam
		 * @return mixed
		 * @throws NotFoundHttpException
		 */
		public function actionGet () {
			Yii::$app->response->format = Response::FORMAT_JSON;
			$res = Users::find()->where(['=', 'steamid', User::ToSteamID(Yii::$app->request->get('steam'))])->one();
			if ($res == null) {
				throw new NotFoundHttpException(Yii::t('app', 'The requested user does not exist.'));
			}
			return $res;
		}

		/**
		 * Displays a single Players model.
		 *
		 * @param string $id
		 * @return mixed
		 */
		public function actionView ($id) {
			return $this->render('view', [
				'model' => $this->findModel($id),
			]);
		}

		/**
		 * Creates a new Players model.
		 * If creation is successful, the browser will be redirected to the 'view' page.
		 *
		 * @return mixed
		 */
		public function actionCreate () {
			$model = new Players();

			if($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
		}

		/**
		 * Updates an existing Players model.
		 * If update is successful, the browser will be redirected to the 'view' page.
		 *
		 * @param string $id
		 * @return mixed
		 */
		public function actionUpdate ($id) {
			$model = $this->findModel($id);

			if($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}

		/**
		 * Deletes an existing Players model.
		 * If deletion is successful, the browser will be redirected to the 'index' page.
		 *
		 * @param string $id
		 * @return mixed
		 */
		public function actionDelete ($id) {
			$this->findModel($id)->delete();

			return $this->redirect(['index']);
		}

		/**
		 * Finds the Players model based on its primary key value.
		 * If the model is not found, a 404 HTTP exception will be thrown.
		 *
		 * @param string $id
		 * @return Players the loaded model
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		protected function findModel ($id) {
			if(($model = Players::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}
	}
