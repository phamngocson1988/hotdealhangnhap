<?php
namespace app\components\utils;
use yii\caching\FileCache;
use Yii;

class QFileCache extends FileCache {
	
	public function getCacheFile($key) {
		return parent::getCacheFile($key);
	}
	
	public function checkCacheBy($key) {
		
		$cache_mode = Yii::$app->params['cache_mode'];
		if (!$cache_mode) return false;
		
		$orgKey = $key;
		
		//add language
		$key = $this->addLanguage2Key($key);
		
		$cache_life_time = Yii::$app->params['cache_life_time'];
		$now = strtotime("now");
		$data = $this->get($orgKey);
		$fileCache = $this->getCacheFile($key);
		if (file_exists($fileCache)) {
			$last_modified_time = filemtime($fileCache);
		} else {
			return false;
		}
		
		$is_valid_cache = $data !== false && file_exists($fileCache) && ($now - $last_modified_time < $cache_life_time);
		
		return $is_valid_cache ? $data : false;
		
	}
	
	public function updateCacheTime($key) {
		$cache_mode = Yii::$app->params['cache_mode'];
		if (!$cache_mode) return false;
		
		$orgKey = $key;
		//add language
		$key = $this->addLanguage2Key($key);
		
		$fileCache = $this->getCacheFile($key);
		if (file_exists($fileCache)) {
			$value = $this->getValueV2($key);
			$duration = Yii::$app->params['cache_life_time'];
			$this->set($orgKey, $value, $duration);
			//touch($fileCache);
		}
	}
	
	protected function getValueV2($key)
	{
		$cacheFile = $this->getCacheFile($key);
		if (file_exists($cacheFile)) {
			$fp = @fopen($cacheFile, 'r');
			if ($fp !== false) {
				@flock($fp, LOCK_SH);
				$cacheValue = @stream_get_contents($fp);
				@flock($fp, LOCK_UN);
				@fclose($fp);
				
				$key = $this->buildKey($key);
				$value = $cacheValue;
				if ($value === false || $this->serializer === false) {
					return $value;
				} elseif ($this->serializer === null) {
					$value = unserialize($value);
				} else {
					$value = call_user_func($this->serializer[1], $value);
				}
				if (is_array($value) && !($value[1] instanceof Dependency && $value[1]->getHasChanged($this))) {
					return $value[0];
				} else {
					return false;
				}
				
			}
		}
	
		return false;
	}
	
	public function set($key, $value, $duration = 0, $dependency = null)
	{
		
		if ($duration == 0) {
			$duration = Yii::$app->params['cache_life_time'];
		}
		//add language
		$key = $this->addLanguage2Key($key);
		return parent::set($key, $value, $duration, $dependency);
	}
	
	private function addLanguage2Key($key) {
		//$language = Yii::$app->language;
		//$key = $key . '-' . $language;
		return $key;
	}
	
	public function get($key) {
		$key = $this->addLanguage2Key($key);
		return parent::get($key);
	}
}