<?php
namespace ModulaR\modularBundle\Model;

use Symfony\Component\Yaml\Yaml;

class AdminModel{

	
	# Parse the YAML files and return modules with correct language
	public static function getModules(){
		$config = self::getConfig();
        $modules = array();
        foreach ($config['modules'] as $m ) $modules[$m] = self::getModule($m);
        return $modules;
	}

	# Parse a module YAML files and return
	public static function getModule($module){
		$lang = self::getLang();
		if($module != "Module") $module .= 'Module';
		$module = Yaml::parse(file_get_contents('bundles/modular/admin/config/'.$module.'.yml'));
        foreach ($module['labels'] as $key => $val ) $module['labels'][$key] = $val[$lang] ;

        if( $module['extends'] )
			return array_replace_recursive(self::getModule($module['extends']) , $module );
        else
			return $module ;
	}

	# Get the language
	public static function getLang(){
		$lang = 'fr';
        return $lang;
	}

	# Get the config
	public static function getConfig(){
        return Yaml::parse(file_get_contents('bundles/modular/admin/config/config.yml'));
	}
	
}
?>