<?php
namespace frontend\forms;

use Yii;
use yii\base\Model;
use common\models\UserAuth;
use common\models\User;
use yii\helpers\ArrayHelper;

class UserAuthForm extends Model
{
	private $client;

	public $id;
	public $name;
	public $email;

	public function setClient($client)
	{
		$this->client = $client;
		$authSupport = $this->authSupport();
		$func = ArrayHelper::getValue($authSupport, $this->client->getId());
		$this->$func();
	}

	public function handle()
	{
		$id = $this->id;
		$name = $this->name;
		$email = $this->email;

		/* @var Auth $auth */
		$auth = UserAuth::findOne(['client' => $this->client->getId(), 'client_user_id' => $id]);

		if (Yii::$app->user->isGuest) {
			if ($auth) { //login
				/* @var User $user */
				$user = $auth->user;
				Yii::$app->user->login($user, Yii::$app->params['user.passwordResetTokenExpire']);
			} else { // signup
				if ($email !== null && User::find()->where(['email' => $email])->exists()) {
					Yii::$app->getSession()->setFlash('error', [ Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
				} else {
					$password = Yii::$app->security->generateRandomString(6);
					$user = new User([
						'name' => $name,
						'username' => $email,
						'email' => $email,
						'password' => $password
					]);
					$user->generateAuthKey();
					$user->generatePasswordResetToken();

					$transaction = Yii::$app->db->beginTransaction();
					if ($user->save()) {
						$auth = new UserAuth([
							'user_id' => $user->id,
							'client' => $this->client->getId(),
							'client_user_id' => (string)$id
						]);
						if ($auth->save()) {
							$transaction->commit();
							Yii::$app->user->login($user, Yii::$app->params['user.passwordResetTokenExpire']);
						} else {
							Yii::$app->getSession()->setFlash('error', [ 
								Yii::t('app', 'Unable to save {client} account: {errors}', [
									'client' => $this->client->getTitle(),
									'errors' => json_encode($auth->getErrors()),
								]),
							]);
						}
					} else {
						Yii::$app->getSession()->setFlash('error', [
							Yii::t('app', 'Unable to save user: {errors}', [
								'client' => $this->client->getTitle(),
								'errors' => json_encode($user->getErrors()),
							]),
						]);
					}
				}
			}
		}
	}

	protected function authSupport()
	{
		return [
			'facebook' => 'facebook',
		];
	}

	protected function facebook()
	{
		$attributes = $this->client->getUserAttributes();

		$this->id = ArrayHelper::getValue($attributes, 'id');
		$this->name = ArrayHelper::getValue($attributes, 'name');
		$this->email = ArrayHelper::getValue($attributes, 'email');
	}
}
?>