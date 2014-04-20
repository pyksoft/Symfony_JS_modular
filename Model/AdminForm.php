<?php
namespace ModulaR\modularBundle\Model;

use Symfony\Component\Yaml\Yaml;

class AdminForm{

	public static function Render($builder){
		$fields = $builder->all();

		foreach ($fields as $key => $value) {
			$field = $builder->get( $key );
		    $options = $field->getOptions();         
		    $type = $field->getType()->getName();
		    $options['attr']['ng-model'] = "data.".$key;
		    $builder->add( $key , $type, $options);
		}
		return $builder;
	}

	public static function PostForm( $builder ){
		$builder
			->add('title'	, 'text')
			->add('content'	, 'textarea');

		return self::Render( $builder );
	}

	public static function UserForm(){
		$builder
			->add('email'		, 'text')
			->add('firstname'	, 'text')
			->add('lastname'	, 'text')
			->add('role'		, 'choice',
				array('choices' => array(
					'admin' => 'Admin',
					'user'  => 'User'
				)))
			->add('bio'			, 'textarea');
			
		return $builder;
	}
}