<?php
namespace common\components\override;

use Yii;
use yii\web\Controller as BaseController;
use yii\web\Response;

/**
 * Controller
 */
class Controller extends BaseController
{
	public function getLimit()
	{
		$request = Yii::$app->request;

        if ($request->get('limit')) {
			return $request->get('limit');
		} elseif ($request->get('per-page')) {
			return $request->get('per-page');
		}
		return 0;
	}

	public function getOffset()
	{
		$request = Yii::$app->request;

		if ($request->get('offset')) {
			return $request->get('offset');
		} elseif ($request->get('page')) {
			return ($page - 1) * $this->getLimit();
		}
		return 0;
	}

	public function renderJson($status, $data = null, $errors = null)
	{
		$response = [
			'status' => $status,
			'data' => $data,
			'errors' => $errors
		];
		Yii::$app->response->format = Response::FORMAT_JSON;
		return $response;
	}
}