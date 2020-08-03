<?php

define('CONFIG_PATH', __DIR__ . '/../sample/config/');
define('DEFAULT_FILE',  'app');


class Config
{

    private $configData;

    private $configDataIndex;

    private $nestedIndex;

    private $lastConfigArray;
    /**
     * @param $config
     * @return array|mixed
     *
     * function to get any configuration value
     */
    public static function get($config, $defaultValue = null, $eniroment = 'development')
    {
        $object = (new static);
        $configFilePath = $object->getConfigFile($config, $eniroment);
        $object->nestedIndex = 1;
        // print_r($object->configData);
        $configName = $object->configData[$object->nestedIndex];
        // die($configName);
        return $object->getValue($configFilePath, $configName, $defaultValue);
    }

    private function getValue($configFilePath, $configName, $defaultValue = null)
    {
        if($this->nestedIndex != 1 && $this->nestedIndex == ($this->configDataIndex - 1))
        {
            return $defaultValue;
        }

        if($this->nestedIndex == 1)
        {
            $configFile = include $configFilePath;
            if(key_exists($configName,$configFile))
            {
                if($configFile[$configName] == null)
                {
                    return $defaultValue;
                }  
                elseif(is_array($configFile[$configName]))
                {
                    $this->nestedIndex++;
                    $this->lastConfigArray = (array) $configFile[$configName];
                    $configName = $this->configData[$this->nestedIndex];
                    return $this->getValue($configFilePath, $configName, $defaultValue = null);
                }
                
                return $configFile[$configName];
            }
        }else{
            $key = $this->configData[$this->nestedIndex];
            if(key_exists($key,$this->lastConfigArray))
            {
                if(is_array($this->lastConfigArray[$key])){
                    $this->nestedIndex++;
                    $this->lastConfigArray = (array) $configFile[$key];
                    return $this->getValue($configFilePath, $key, $defaultValue = null);
                }  
                else if($this->lastConfigArray[$key] != null)
                {
                    return $this->lastConfigArray[$key];
                }
                
            }
                
        }
        
        return $defaultValue;
    }

    /**
     * @return mixed
     *
     * function to get configurations from configure.json
     */
    private function getConfigFile($config, $eniroment)
    {
        if (!is_array($config)) {
            $this->configData = explode('.', $config);
        } else {
            $this->configData = $config;
        }
        $this->configDataIndex = count($this->configData);

    
        // print_r($config);
        $file = $this->configData[0];
       
        // $file = $this->configData[0];
        $eniroment = $eniroment  ==   null ? 'development' : $eniroment;
        $file = CONFIG_PATH . '/' . $eniroment . '/' . $this->arrayFirstFile() . '.php';
        return is_file($file) ? $file : CONFIG_PATH . $eniroment . '/' . DEFAULT_FILE . '.php';
    }

    private function arrayFirstFile()
    {
        $fileName = null;
        if (count($this->configData) > 1) {
            $fileName = $this->configData[0];
        }

        return $fileName;
    }
}



function config($config, $defaultValue = null, $eniroment = 'development')
{
    return  Config::get($config, $defaultValue, $eniroment);
}