<?php
/**
 * Created by JetBrains PhpStorm.
 * @author: Oficerov Kirill
 * Date: 24.11.12
 * Time: 15:58
 */

class Wd_Parts_MainMenu {
	public static function addHomeButton($menu) {
		if(isset($menu[0])) {
			$menu[0]->url = 'http://' . $_SERVER['HTTP_HOST'];
			$menu[0]->title = 'Главная';
		}
		foreach($menu as $key => &$value) {
			if($value->title == 'Мобайл') {
//				$value->classes[0] = 'category-yellow-right-border';
				$value->colored = 'category-yellow';
			} elseif($value->title == 'Дизайн') {
//				$value->classes[0] = 'category-orange-right-border';
				$value->colored = 'category-orange';
			} elseif($value->title == 'Проектирование') {
//				$value->classes[0] = 'category-green-light-right-border';
				$value->colored = 'category-green-light';
			} elseif($value->title == 'Веб') {
//				$value->classes[0] = 'category-green-bright-right-border';
				$value->colored = 'category-green-bright';
			} elseif($value->title == 'Медиа') {
//				$value->classes[0] = 'category-white-right-border';
				$value->colored = 'category-white';
			}
		}

		return $menu;
	}
}