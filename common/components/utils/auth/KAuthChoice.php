<?php
namespace app\components\utils\auth;

use yii\authclient\widgets\AuthChoice;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class KAuthChoice extends AuthChoice 
{
    public $block = ''; //register OR login for render
    public $register = ['google', 'facebook'];
    /**
     * @inheritdoc
     */
    public $clientIdGetParamName = 'provider';
    /**
     * @inheritdoc
     */
    public $options = [];

    //vvdung
    public function getRegister() {
        if (Yii::$app->language == 'ko') {
            $this->register[] = 'naver';
        }
        else {
            $this->register[] = 'linkedin';
        }
        return $this->register;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderMainContent()
    {
        if (strpos($this->getId(), 'w_connect') !== false) {
            $this->_htmlConnect();
        } else {
            echo Html::beginTag('ul');
            foreach ($this->getClients() as $externalService) {
                $provider = $externalService->getName();
                if (!in_array($provider, $this->getRegister())) {
                    continue;
                }
                echo Html::beginTag('li');
                $content = Html::beginTag('div', ['class' => $provider.'-block']);
                $content .= Html::tag('span', '', ['class' => 'qa qa-social-'.$provider]);
                if ($this->getId() == 'w_register') {
                    $text = Yii::t('L2', 'Sign up with {provider}', ['provider' => ucfirst($provider)]);
                } else {
                    $text = Yii::t('L1', ucfirst($provider));
                }
                $content .= Html::tag('span', $text);
                $content .= Html::endTag('div');
                $this->clientLink($externalService, $content);
                echo Html::endTag('li');
            }
            echo Html::endTag('ul');
        }
    }
    
    private function _htmlConnect() {
        foreach ($this->getClients() as $externalService) {
            $provider = $externalService->getName();
            if (!in_array($provider, $this->register)) {
                continue;
            }
            $content = Html::tag('span', '<span class="qa qa-social-'.$provider.'"></span>', ['class' => 'btn-icon']);
            $content .= Html::beginTag('div', ['class' => 'btn-text text_left']);
            $content .= Yii::t('My1.6', 'Connect to '.ucfirst($provider).' account');
            $content .= Html::endTag('div');
            $this->clientLink($externalService, $content);
        }
    }
    
    /**
     * Composes client auth URL.
     * @param ClientInterface $provider external auth client instance.
     * @return string auth URL.
     */
    public function createClientUrl($provider)
    {
        $this->autoRender = false;
        $url = $this->getBaseAuthUrl();
        $url[$this->clientIdGetParamName] = $provider->getId();

        Yii::$app->session->set('account_redirect_language', Yii::$app->language);
        
        $validController = (Yii::$app->controller->id != 'brand');
        if (isset($url[0]) && $validController && 
                ($url[0] == 'user/auth' || $url[0] == 'account/connect')) {
            //Yii::$app->urlManager->baseUrl = str_replace(['/ko', '/vi'], '', Yii::$app->urlManager->baseUrl);
            $new_url = Url::to($url);
            return str_replace(['/ko', '/vi'], '', $new_url);
        }
        return Url::to($url);
    }    
}

