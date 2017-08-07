<?php

namespace app\components\utils;

use app\models\quark\logic\implement\LanguageModelImpl;
use Yii;
use app\components\utils\KDateFormat;
use yii\helpers\ArrayHelper;

include(dirname(__FILE__) . '/lib_autolink.php');

class KDataUtil {

    protected static $localData = array();
    protected static $arrUserLang = array();
    protected static $arrShowLang = array();
    protected static $arrLoginUserLang = array();
    public static $socialProvider = array('puzzle', 'google', 'facebook', 'twitter', 'kakao', 'naver');

    public static function ypGetLocalData() {
        if (empty(self::$localData)) {
            self::$localData = array('viewLanguageCode' => Yii::$app->language);
        }
        return self::$localData;
    }

    /**
     * Returns a string in a URL friendly format. This function is
     * recommended to be used on non-multibyte character sets. So 
     * this is not recommended for UTF-8, since certain PHP 
     * functions (like strtolower) should not be used on multibyte
     * strings.
     * @param string $str The input string.
     * @return string The URL friendly string.
     */
    public static function getUrlFriendlyString($str) {
        // Replace non-alphanumeric characters with '-'
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', "-", $str);
        $str = mb_strtolower($str, mb_detect_encoding($str));
        $str = trim($str, '-');
        return $str;
    }

    public static function autoParagraph($str) {
        $str = nl2br($str);
        $str = '<p>' . preg_replace("/<br[^>]*>/", "</p><p>", $str) . '</p>';
        return $str;
    }

    public static function encodeFilename($filename) {
        return preg_replace("/[^\p{L}\p{N}.]/u", "_", $filename);
    }

    public static function ypGetErrors($model) {
        $content = "";
        foreach ($model->getErrors() as $errors) {
            foreach ($errors as $error) {
                if ($error != '')
                    $content .= "$error" . '<br>';
            }
        }
        return $content;
    }

    public static function displayAvatar($filename, $path, $type = 42) {
        $baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
        if ($type == 42) {
            $src = $baseUrl . '/images/editor/contact_thumb.gif';
        } elseif ($type == 55) {
            $src = $baseUrl . '/images/editor/contact_thumb.gif';
        } elseif ($type == 80) {
            $src = $baseUrl . '/images/main/user_avata_80.png';
        } else {
            $src = $baseUrl . '/images/editor/contact_thumb.gif';
        }
        if ($filename != "" && file_exists(Yii::$app->params['fileRoot'] . "/$path/$filename")) {
            $src = Yii::$app->params['fileUrl'] . "/$path/$filename";
        }
        return $src;
    }

    public static function ypGetThumbnailAvatar($model, $size) {
        $src = self::displayAvatar("", "", $size);
        $folder = $size . 'x' . $size;
        if (!empty($model->user_photo_id)) {
            $avatar_path = substr($model->path, 5);
            $src = self::displayAvatar($model->filename, "user/thumb/$folder/$avatar_path", $size);
        } elseif (!empty($model->social_avatar_id)) {
            $user_id = (isset($model->user_id)) ? $model->user_id : $model->id;
            $avatar_path = self::ypGenerateFolderUser($user_id, $model->social_avatar_id, '', 'web'); //"/394/8"
            $src = self::displayAvatar($model->social_avatar_id . '.jpg', "user/thumb/$folder$avatar_path", $size);
        } elseif (!empty($model->social_identifier) && $model->provider) {
            if ($model->provider == 'facebook') {
                $src = "http://graph.facebook.com/$model->identifier/picture?width=$size" . "&height=$size";
            }
            if ($model->provider == 'google') {
                $param = stripos($model->social_avatar_url, '?') === false ? '?size=' : '&size=';
                $src = $model->social_avatar_url . $param . $size;
            }
        }
        return $src;
    }

    public static function ypCheckUrlValidate($route, $titleModel, $typeId = 'id') {
        $langUrl = Language::getSiteLanguage();

        $id = Yii::$app->request->getParam($typeId);
        $title = Yii::$app->request->getParam('title');

        if ($titleModel != $title || !Language::checkLanguageActive($langUrl)) {
            Yii::$app->controller->redirect(array($route,
                'language' => Language::getViewLanguage(),
                $typeId => $id,
                'title' => $titleModel
            ));
        }
    }

    /**
     * @param int $id 12345
     * @param string $folder //photo, floorplan ...
     * @param string $type //default generate folder
     * @return photo/345/12
     */
    public static function ypGenerateFolder($id, $folder, $type = 'cms') {
        // generate folder from id
        $directory = array();
        $path = '';
        while ($id) {
            $directory[] = substr($id, -3);
            if (strlen($id) - 3 < 0) {
                $id = 0;
            } else {
                $id = substr($id, 0, strlen($id) - 3);
            }
        }

        if ($type == 'cms') {
            $subfolders = explode('/', $folder);
            $f = '';
            foreach ($subfolders as $subfolder) {
                $f .= "/$subfolder";
                if (!is_dir(Yii::$app->params['fileRoot'] . $f)) {
                    mkdir(Yii::$app->params['fileRoot'] . $f, 0777, true);
                }
            }
        }

        foreach ($directory as $dir) {
            $path .= '/' . $dir;
            if ($type == 'cms') {
                if (!is_dir(Yii::$app->params['fileRoot'] . '/' . $folder . $path)) {
                    mkdir(Yii::$app->params['fileRoot'] . '/' . $folder . $path, 0777, true);
                }
            }
        }
        return $folder . $path;
    }

    public static function ypGenerateFolderUser($user_id, $photo_id, $folder, $type = '') {
        // generate folder from user_id
        $number = substr($photo_id, -1);
        $directory = array();
        $path = '';
        while ($user_id) {
            $directory[] = substr($user_id, -3);
            if (strlen($user_id) - 3 < 0) {
                $user_id = 0;
            } else {
                $user_id = substr($user_id, 0, strlen($user_id) - 3);
            }
        }
        if (!empty($directory)) {
            $directory[] = $number;
        }

        if ($type == 'create') {
            $subfolders = explode('/', $folder);
            $f = '';
            foreach ($subfolders as $subfolder) {
                $f .= "/$subfolder";
                if (!is_dir(Yii::$app->params['fileRoot'] . $f)) {
                    mkdir(Yii::$app->params['fileRoot'] . $f, 0777, true);
                }
            }
        }

        foreach ($directory as $dir) {
            $path .= '/' . $dir;
            if ($type == 'create') {
                if (!is_dir(Yii::$app->params['fileRoot'] . '/' . $folder . $path)) {
                    mkdir(Yii::$app->params['fileRoot'] . '/' . $folder . $path, 0777, true);
                }
            }
        }
        return $folder . $path;
    }

    public static function ypFormatDataMultipleCheckbox($arrLanguageSpoken) {
        $out = $temp = array();
        foreach ($arrLanguageSpoken as $rowkey => $row) {
            foreach ($row as $colkey => $col) {
                if (!empty($col)) {
                    $temp[] = $colkey;
                    $out[$colkey][$rowkey] = $col;
                }
                if (in_array($colkey, $temp)) {
                    $out[$colkey][$rowkey] = $col;
                }
            }
        }
        return $out;
    }

    public static function ypFormatDisplayText($string) {
        //$string = nl2br(self::ypHtmlEntities($string));
        // custom code
        //$string = make_link($string);
        $string = autolink($string, 100);
        return $string;
    }

    public static function ypEncodeText($string) {
        $string = rawurlencode(stripcslashes($string));

        return $string;
    }

    public static function ypHtmlEntities($string) {
        return htmlentities($string, ENT_QUOTES, "UTF-8");
    }

    public static function generateLinkUser($data) {
        if (isset($data['social_provider']) && $data['social_provider'] != '') {
            $user_name = ArrayHelper::getValue($data, 'social_name');
            return '<span class="commenter">' . $user_name . '</span>';
        } else {
            $user_name = User::ypDisplayUsername($data);
            return '<a class="commenter user_link" href="javascript:void(0);" >' . $user_name . '</a>';
        }
    }

    public static function generateLinkAvatarUser($data) {
        $identifier = ArrayHelper::getValue($data, 'social_identifier');
        $text = '';
        if (isset($data['avatar_src'])) {
            $text .= '<span class="comm_avata"><img class="contexCtrl tooltipy tip-profile tooltip-c-scroll" data-user=\'' . json_encode($data['user_data']) . '\' src="' . $data['avatar_src'] . '"></span>';
        } else {
            $user_id = ArrayHelper::getValue($data, 'user_id');
            $user_photo_id = ArrayHelper::getValue($data, 'user_photo_id');
            $path = KDataUtil::ypGenerateFolderUser($user_id, $user_photo_id, 'user', 'web');
            $model = array(
                'id' => $user_id,
                'user_photo_id' => $user_photo_id,
                'path' => $path,
                'filename' => ArrayHelper::getValue($data, 'avatar_name'),
            );
            $model = (object) $model;
            $avatar_src = KDataUtil::ypGetThumbnailAvatar($model, 38);
            $text .= '<span class="comm_avata"><img class="contexCtrl tooltipy tip-profile tooltip-c-scroll" src="' . $avatar_src . '"></span>';
        }
        return $text;
    }

    public static function generateAvatarUser($data) {
        $user_id = $data['user_id'];
        $user_photo_id = ArrayHelper::getValue($data, 'user_photo_id');
        $avatar = ArrayHelper::getValue($data, 'avatar_name');
        echo '<img class="contexCtrl tooltipy tip-profile tooltip-c-scroll" data-user=\'' . json_encode($data['user_data']) . '\' src="' . KDataUtil::displayAvatar($avatar, KDataUtil::ypGenerateFolderUser($user_id, $user_photo_id, 'user/thumb/38x38', 'web')) . '">';
    }

    public static function setFlashError($model) {
        $errors = $model->getErrors();
        foreach ($errors as $key => $error) {
            Yii::$app->user->setFlash($key, ArrayHelper::getValue($error, 0));
        }
    }

    public static function getFlashError($errors) {
        $str = '';
        if (!empty($errors)) {
            $str .= '<div class="errorSummary"><ul>';
            foreach ($errors as $key => $message) {
                $str .= '<li>' . $message . '</li>';
            }
            $str .= '</ul></div>';
        }
        echo $str;
    }

    public static function hasOnline() {
        if (!Yii::$app->user->isGuest) {
            return true;
        } else {
            $session = Yii::$app->session;
            foreach (KDataUtil::$socialProvider as $provider) {
                if (isset($session['social_' . $provider])) {
                    $socialData = $session['social_' . $provider];
                    $identifier = ArrayHelper::getValue($socialData, 'identifier');
                    if ($identifier != '') {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function isOnline($provider) {
        if ($provider != 'puzzle') {
            $session = Yii::$app->session;
            if (isset($session['social_' . $provider])) {
                $socialData = $session['social_' . $provider];
                $identifier = ArrayHelper::getValue($socialData, 'identifier');
                if ($identifier != '') {
                    return true;
                }
            }
        } else {
            if (isset(Yii::$app->user->id)) {
                return true;
            }
        }
        return false;
    }

    public static function getSocialChecked() {
        $session = Yii::$app->session;
        $checked = ArrayHelper::getValue($session, 'social_checked');
        if ($checked != '') {
            return $checked;
        }
        return '';
    }

    public static function getSocialCheckedData($attr) {
        $session = Yii::$app->session;
        $checked = ArrayHelper::getValue($session, 'social_checked');
        $socialData = $session['social_' . $checked];
        return ArrayHelper::getValue($socialData, $attr);
    }

    public static function setSocialChecked($user_id = '') {
        $session = Yii::$app->session;
        $flag = false;
        foreach (KDataUtil::$socialProvider as $provider) {
            if (KDataUtil::isOnline($provider) || $user_id != '') {
                $flag = true;
                $session['social_checked'] = $provider;
                break;
            }
        }
        if (!$flag) {
            unset($session['social_checked']);
        }
    }

    // get text by language
    public static function getIndexByLang(&$data, $name, $alias, $suffix = '_text', $isTitle = false) {
        $arrLang = array('en' => 1, 'ko' => 1);
        foreach ($arrLang as $lang => $val) {
            if ($lang != 'null' && isset($data[$name . '_' . $lang . $suffix])) {
                $data[$alias] = $data[$name . '_' . $lang . $suffix];
                $data['language_code'] = $lang;
                if ($isTitle) {
                    $data['title_lang'] = $lang;
                }
                break;
            } else {
                $data[$alias] = '';
            }
        }
        return $data[$alias];
    }

    public static function ypGetThumbnailImage($filename, $path, $default = '/images/main/ikProfile_big.png') {
        if ($default == '') {
            //$default = Yii::$app->params['baseUrl'] . '/images/main/atexpat_nophoto_blue_80x56.png';
        }
        $src = $default;
        if ($filename != "" && file_exists(Yii::$app->params['fileRoot'] . "/$path/$filename")) {
            $src = Yii::$app->params['fileUrl'] . "/$path/$filename";
        }
        return $src;
    }

    public static function ypLanguageDateFormat($date_format, $timestamp = "") {
        $lang_date_format = KDateFormat::getDateFormat();
        if (empty($timestamp)) {
            $timestamp = time();
        }
        if ($lang_date_format) {
            $language_code = Yii::$app->language;
            if (!empty($lang_date_format[$language_code]['format'][$date_format])) {
                return strftime($lang_date_format[$language_code]['format'][$date_format], $timestamp);
            }
        }
        return date($date_format, $timestamp);
    }

    public static function getDefaultUserAvatar($type = 80) {
        if ($type == 38) {
            $src = Yii::$app->getUrlManager()->getBaseUrl() . '/images/editor/contact_thumb.gif';
        } elseif ($type == 23) {
            $src = Yii::$app->getUrlManager()->getBaseUrl() . '/images/editor/contact_thumb.gif';
        } elseif ($type == 78) {
            $src = Yii::$app->getUrlManager()->getBaseUrl() . '/images/main/user_avata_logo.gif';
        } elseif ($type == 80) {
            $src = Yii::$app->getUrlManager()->getBaseUrl() . '/images/main/user_avata_80.png';
        } else {
            $src = Yii::$app->getUrlManager()->getBaseUrl() . '/images/main/user_avata_80.png';
        }
        return $src;
    }

    public static function time_elapsed_string($ptime, $lang = 'en') {
        $etime = time() - $ptime;
        if ($etime < 1) {
            //return '0 ' . Yii::t('GLB:Datetime', 'second');
            return Yii::t('GLB:Datetime', 'Now');
        }
        $a = array(
            31104000 => Yii::t('GLB::Datetime', '{n} year ago|{n} years ago'),
            2592000 => Yii::t('GLB::Datetime', '{n} month ago|{n} months ago'),
            86400 => Yii::t('GLB::Datetime', '{n} day ago|{n} days ago'),
            3600 => Yii::t('GLB::Datetime', '{n} hour ago|{n} hours ago'),
            60 => Yii::t('GLB::Datetime', '{n} minute ago|{n} minutes ago'),
            1 => Yii::t('GLB::Datetime', '{n} second ago|{n} seconds ago')
        );
        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                if ($secs == 31104000) {
                    return Yii::t('GLB::Datetime', '{n, plural, =1{# year} other{# years}} ago', ['n' => $r]);
                } else if ($secs == 2592000) {
                    return Yii::t('GLB:Datetime', '{n, plural, =1{# month} other{# months}} ago', ['n' => $r]);
                } else if ($secs == 86400) {
                    return Yii::t('GLB::Datetime', '{n, plural, =1{# day} other{# days}} ago', ['n' => $r]);
                } else if ($secs == 3600) {
                    return Yii::t('GLB::Datetime', '{n, plural, =1{# hour} other{# hours}} ago', ['n' => $r]);
                } else if ($secs == 60) {
                    return Yii::t('GLB::Datetime', '{n, plural, =1{# minute} other{# minutes}} ago', ['n' => $r]);
                } else if ($secs == 1) {
                    return Yii::t('GLB::Datetime', '{n, plural, =1{# second} other{# seconds}} ago', ['n' => $r]);
                } else {
                    return Yii::t('GLB::Datetime', $str, $r);
                }
            }
        }
    }

    /**
     * @param $path
     * @param $filename
     * @param $thumbnails
     * @param $photo_id
     * @param string $type
     * @return bool|void
     */
    public static function ypSaveImageThumbnails($path, $filename, $thumbnails, $photo_id, $type = '', $user_id = '') {
        Yii::beginProfile('CreateThumb');
        if (empty($thumbnails)) {
            return;
        }
        $user_id = get_class(Yii::$app) == 'yii\console\Application' || empty(Yii::$app->user->id) ? $user_id : Yii::$app->user->id;
        if ($type != 'tmp') {
            $folder = 'user/thumb';
            $pathThumb = KDataUtil::ypGenerateFolderUser($user_id, $photo_id, '', 'web'); //user_id = 12345, photo_id = 123 => 345/12/3
        }
        //main thumb 588 - 322 - 210 - 106 - 60
        $fileroot = $filename;
        try {
            $thumbRoot = Yii::$app->image->load($path . '/' . $fileroot);
        } catch (Exception $ex) {
            return 'image_invalid';
        }
        list($width, $height) = getimagesize($path . '/' . $fileroot);

        $r = $height / $width;
        foreach ($thumbnails as $thumbnail) {
            $thumb = Yii::$app->image->load($path . '/' . $fileroot);
            $widthThumb = $thumbnail[0];
            $heightThumb = $thumbnail[1];
            if ($thumbnail[0] == 'auto' && $thumbnail[1] != 'auto') { //width = auto, but height = integer
                $thumbnail[0] = round(($thumbnail[1] * $width) / $height);
            }
            if ($thumbnail[1] == 'auto' && $thumbnail[0] != 'auto') { //height = auto, but width = integer
                $thumbnail[1] = round(($thumbnail[0] * $height) / $width);
            }
            $R = $thumbnail[1] / $thumbnail[0];
            if ($type == 'tmp') {
                $thumbPath = 'tmp_upload';
                $filename = 'thumb_' . $filename;
            } else {
                $thumbPath = KDataUtil::ypGenerateFolderUser($user_id, $photo_id, $folder . '/' . $widthThumb . 'x' . $heightThumb, 'create'); //user/thumb/160x160/345/12/3
            }

            if ($type != 'overwrite' && is_file(Yii::$app->params['fileRoot'] . '/' . $thumbPath . '/' . $filename)) {
                continue;
            }
            if ($type == 'editor' && $width <= 737 && $widthThumb == 737) {
                copy($path . '/' . $fileroot, Yii::$app->params['fileRoot'] . '/' . $thumbPath . '/' . $filename);
                continue;
            }
            if (in_array($type, ['insider', 'avatar', 'editor'])) {
                $params = [
                    'type' => $type,
                    'path' => $thumbPath,
                    'filename' => $fileroot,
                    'widthThumb' => $widthThumb,
                    'heightThumb' => $heightThumb,
                ];
                $thumb = self::getThumb($thumb, $params);
            }

            if ($r > $R) {
                $thumb->resize($thumbnail[0], $thumbnail[1], \yii\image\drivers\Kohana_Image::WIDTH); //resize follow WIDTH
                $thumb->crop($thumbnail[0], $thumbnail[1]);
            }
            if ($r < $R) {
                $thumb->resize($thumbnail[0], $thumbnail[1], \yii\image\drivers\Kohana_Image::HEIGHT); //resize follow HEIGHT
                $thumb->crop($thumbnail[0], $thumbnail[1]);
            }
            if ($r == $R) {
                $thumb->resize($thumbnail[0], $thumbnail[1]);
            }

            $thumbPath = Yii::$app->params['fileRoot'] . '/' . $thumbPath;
            if (!file_exists($thumbPath)) {
                @mkdir($thumbPath, 0x777, true);
            }
            $thumb->save($thumbPath . '/' . $filename); //save vao thumb
        }
        $thumb = null;
        Yii::endProfile('CreateThumb');
        return true;
    }

    /**
     * Load before thumb for after thumb
     * @param object $thumb
     * @param array $thumbnail, widthxheight
     * @param string $type (avatar, editor, insider)
     * @return type
     */
    private static function getThumb($thumb, $params) {
        $type = $params['type'];
        $widthThumb = $params['widthThumb'];
        $heightThumb = $params['heightThumb'];
        $path = $params['path'];
        $filename = $params['filename'];
        $size = $widthThumb . 'x' . $heightThumb;
        $check = false;
        if ($type == 'avatar') {
            if ($widthThumb < 80) {
                $path = str_replace($size, '80x80', $path);
                $check = true;
            }
        } elseif ($type == 'editor') {
            if ($widthThumb < 737) {
                $path = str_replace($size, '737xauto', $path);
                $check = true;
            }
        } elseif ($type == 'insider') {
            if ($widthThumb < 160) {
                $path = str_replace($size, '160x160', $path);
                $check = true;
            }
        }
        if ($check == true) {
            if (file_exists(Yii::$app->params['fileRoot'] . "/$path/$filename")) {
                $thumb = Yii::$app->image->load(Yii::$app->params['fileRoot'] . "/$path/$filename");
            }
        }
        return $thumb;
    }

    /**
     * Check a string is serialized or not
     * @author Son Pham
     * @param string $str
     * @return boolean
     */
    public static function is_serialized($str) {
        $data = @unserialize($str);
        if ($data !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * List months translated
     * @return array
     */
    public static function birthMonth() {
        return array(Yii::t("GLB:Datetime", "January"), Yii::t("GLB:Datetime", "February"), Yii::t("GLB:Datetime", "March"), Yii::t("GLB:Datetime", "April"), Yii::t("GLB:Datetime", "May"), Yii::t("GLB:Datetime", "June"),
            Yii::t("GLB:Datetime", "July"), Yii::t("GLB:Datetime", "August"), Yii::t("GLB:Datetime", "September"), Yii::t("GLB:Datetime", "October"), Yii::t("GLB:Datetime", "November"), Yii::t("GLB:Datetime", "December")
        );
    }

    /*
     * check user privilege
     */

    public static function checkPrivilege($insiderId, $section, $action) {
        $userSectionPrivs = Yii::$app->user->id ? Yii::$app->user->identity->UserSectionPrivs : [];
        if (!empty($userSectionPrivs)) {
            if (isset($userSectionPrivs[$insiderId][$section][$action])) {
                return 1;
            }
        }
        return 0;
    }

    public static function getArrayValue($array, $keys, $default = null) {
        foreach ($keys as $k) {
            // if (isset($array[$k])) {
            if (ArrayHelper::getValue($array, $k)) {
                return $array[$k];
            }
        }
        return $default;
    }

    public static function file_get_contents_utf8($url) {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type: text/html; charset=utf-8"
            )
        );

        $context = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);
        return $result;
    }

    public static function file_get_contents_img($url, $type = 'image/jpeg') {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type:' . $type . '; charset=utf-8"
            )
        );

        $context = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);
        return $result;
    }

    public static function getImageUrl($userId, $photoId, $fileName, $thumb = null, $default = null) {
        $folder = "user";
        if ($thumb != null) {
            $folder = "user/thumb/$thumb";
        }
        $path = self::ypGenerateFolderUser($userId, $photoId, $folder);
        return self::ypGetThumbnailImage($fileName, $path, $default);
    }

    /**
     * Calculate the point of a factor
     * @author pnson
     * @param int $item
     * @return number
     */
    public static function getPoint($item) {
        $n = min(floor($item / 10), 9); // int $n = [0,9];
        if (fmod($item, 10) == 0) {
            $n = max(0, $n - 1);
        }

        $dn = 1 - (0.1 * $n);
        $c = 1.1 * $n - 0.1 * array_sum(range(0, $n));
        $p = $c + ($item - 10 * $n) / 10 * $dn;
        return $p;
    }

    /*
     * remove special charater
     */

    public static function filterTag($tag) {
        $tag = self::removeEmoji($tag);
        //$tag = trim(preg_replace("/\p{P}|\p{S}/u", "", $tag));
        return $tag;
    }

    public static function removeEmoji($text) {
        return preg_replace('/([0-9|#][\x{20E3}])|[\x{200B}-\x{200D}]|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $text);
    }

    /**
     * Tung
     */
    public static $unescaped = array(' ', '"', '&', '\'', '/', ':', '>', '<', '@');
    public static $escaped = array('\20', '\22', '\26', '\27', '\2f', '\3a', '\3c', '\3e', '\40');

    public static function escapeJabberUsername($username) {
        $unescaped = self::unescaped;
        $escaped = self::escaped;
        $ret = str_replace('\\', '\5c', $username);
        $ret2 = str_replace($unescaped, $escaped, $ret);
        return $ret2;
    }

    public static function unescapeJabberUsername($e) {
        $unescaped = self::unescaped;
        $escaped = self::escaped;
        $unescaped[] = '\\';
        $escaped[] = '\5c';
        $ret = str_replace($escaped, $unescaped, $e);
        return $ret;
    }

    /**
     * Call to remote service
     * @param string $url the remote url
     * @param array $data pair of key/value, parameters user want to send
     * @param string $method post/get
     * @return boolean
     */
    public static function sendRemoteService($url, $data, $method = 'get') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        // Init data
        $query = http_build_query($data);

        if (strtolower($method) == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        } else {
            curl_setopt($ch, CURLOPT_URL, "$url&$query");
        }
        $output = curl_exec($ch);
        $errno = curl_errno($ch);
        $flag = ($errno == 0) ? $output : "CURL is ERROR, errno $errno.";

        // Close handle
        curl_close($ch);
        return $flag;
    }

    /**
     * Special characters like "!, $, %, ^, &, *, +, ." will not work AND ", , /, #, -"
     */
    public static function filterValueBand($valueBand) {
        $special = array('!', '$', '%', '^', '&', '*', '+', '.', ',', '/', '#', '-');
        return str_replace($special, '', $valueBand);
    }

    /* nttay */

    public static function getValueBandFormat($raw_name, $category, $language_code) {
        $formatNameValueBand = [
            'en' => $raw_name . " " . $category,
            'ko' => $raw_name . " " . $category,
            'vi' => $category . " " . $raw_name,
        ];
        if (empty($formatNameValueBand[$language_code])) {
            return $formatNameValueBand['ko'];
        }
        return $formatNameValueBand[$language_code];
    }

    public static function getValueBandDisplay($raw_name, $category, $language_code) {
        $formatNameValueBand = [
            'en' => $raw_name . " [" . $category . "]",
            'ko' => $raw_name . " [" . $category . "]",
            'vi' => "[" . $category . "] " . $raw_name,
        ];
        if (empty($formatNameValueBand[$language_code])) {
            return $formatNameValueBand['ko'];
        }
        return $formatNameValueBand[$language_code];
    }

    protected static function valuebandTranslation() {
        $step1 = [
            'en' => ['My company is engaged in', '', '', 'Product or Service', 'Select', 'OK', 'Search for'],
            'ko' => ['우리  회사는', '를', '하고 있습니다', '제품 또는 서비스', '선택', '확인', 'Search for', '을(를) 하고 있는 회사입니다'],
            'vi' => ['Công ty chúng tôi', '', '', 'Sản phẩm hoặc dịch vụ', 'Chọn', 'OK', 'Tìm'],
        ];
        $step3 = [
            'en' => ['This quark’s marketing targets are companies engaged in', '', '', 'Product or Service', 'Select', 'OK', 'Search for'],
            'ko' => ['이 쿼크의 마케팅 대상은', '을', '하고 있는 회사입니다', '제품 또는 서비스', '선택', '확인', 'Search for'],
            'vi' => ['Quark dành cho các công ty chuyên về', '', '', 'Sản phẩm hoặc dịch vụ', 'Chọn', 'OK', 'Tìm'],
        ];
        $alert = [
            'en' => ['Please select a category.'],
            'ko' => ['카테고리를 선택하세요.'],
            'vi' => ['Hãy chọn một danh  mục.'],
        ];
        return ['step1' => $step1, 'step3' => $step3, 'alert' => $alert];
    }

    public static function searchValueBandOrder($language_code) {
        $set = [
            'en' => ['valueband', 'category'],
            'ko' => ['valueband', 'category'],
            'vi' => ['category', 'valueband'],
        ];

        return ArrayHelper::getValue($set, $language_code, $set['en']);
    }

    public static function getListLanguagesNotify($languageCode = '') {
        $notify = [
            'en' => 'New Value Link',
            'ko' => '새 밸류링크',
            'vi' => 'Value link mới',
        ];
        return $notify;
    }

    public static function getListLanguages($languageCode = '') {
        $translations = self::valuebandTranslation();
        $step1 = $translations['step1'];
        $step3 = $translations['step3'];
        $alert = $translations['alert'];
        $langs = LanguageModelImpl::getListDisplayLanguages();

        $set = [];
        foreach ($langs as $code => $lang) {
            $order = self::searchValueBandOrder($code);

            $set[$code] = [
                'order' => $order[0] . '_' . $order[1],
                'text_step1' => ArrayHelper::getValue($step1, $code, $step1['en']),
                'text_step3' => ArrayHelper::getValue($step3, $code, $step3['en']),
                'alert' => ArrayHelper::getValue($alert, $code, $alert['en']),
                'name' => $lang
            ];
        }

        if (empty($languageCode)) {
            $result = $set;
        } elseif (!isset($set[$languageCode])) {
            $result = $set['en'];
        } else {
            $result = $set[$languageCode];
        }

        return $result;     //ArrayHelper::getValue($set, $languageCode, $set);
    }

    public function checkIEBrowserVersion($version) 
    {
        // preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
        // if (count($matches) < 2) {
        //   preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
        // }

        // if (count($matches)>1){
        //   //Then we're using IE
        //   $version = $matches[1];

        //   switch(true){
        //     case ($version<=8):
        //       //IE 8 or under!
        //       break;

        //     case ($version==9 || $version==10):
        //       //IE9 & IE10!
        //       break;

        //     case ($version==11):
        //       //Version 11!
        //       break;

        //     default:
        //       //You get the idea
        //   }
        // }
    }

    public static function show_alert($message, $location = null, $is_return = false)
    {
    if( $location == 'back' ){
        $location = 'history.back();';
    } else if( $location == 'close' ){
        $location = 'self.close();';
    } else if( $location == 'reload' ){
        $location = 'location.reload();';
    } else if( $location ){
        $location = 'location.href="' . $location . '";';
    }
    $return_src = <<<ALERT
    <script type="text/javascript">
        alert("$message");
        $location
    </script>
ALERT;

    if( $is_return ){
        return $return_src;
    }
    echo $return_src;
    exit;
    }

    public static function generateCacheKeyByName($name) {
    	return md5(Yii::$app->user->isGuest . '_' . Yii::$app->request->isAjax . '_' . $name . '_' . Yii::$app->language);
    }
    
    /**
     * @param photos array
     */
    public static function checkVideoThumb($photos)
    {
        $regExpYoutube = "/(\/\/img.youtube.com)\/?(\S+)?/";
        $regExpVimeo = "/^(https\:\/\/)?(i.vimeocdn.com)\/?(\S+)?/";
        $result = array();
        foreach ((array)$photos as $key => $photo) {
            if (preg_match($regExpYoutube, $photo)) {
                $result['position'] = $key;
                $result['url'] = $photo;
                $result['type'] = "youtube";
                return $result;
            } elseif (preg_match($regExpVimeo, $photo)) {
                $result['position'] = $key;
                $result['url'] = $photo;
                $result['type'] = "vimeo";
                return $result;
            }
        }
        return;
    }
    
    public static function omitLowToken($keyword) {
    	 $arr_keywords = explode(" ", $keyword);
    	 if (count($arr_keywords) <= 1) return $keyword; 
    	 $results = array();
    	 foreach ($arr_keywords as $token) {
    	 	if (mb_strlen($token, 'utf-8') > 1) {
    	 		$results[] = $token;
    	 	}
    	 }
    	 return implode(" ", $results);
    }
     /**
     * @param $microsecond microseconds
     */
    public static function ksleep($microsecond = 1100000)
    {
    	if (Yii::$app->params['disable_commit_all']) {
	    	$microsecond = Yii::$app->params['sleep_time'];
	        //wait for indexing
	        usleep($microsecond);
    	}
    }

}
