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
				$value->colored = 'category-yellow';
			} elseif($value->title == 'Дизайн') {
				$value->colored = 'category-orange';
			} elseif($value->title == 'Проектирование') {
				$value->colored = 'category-green-light';
			} elseif($value->title == 'Веб') {
				$value->colored = 'category-green-bright';
			} elseif($value->title == 'Медиа') {
				$value->colored = 'category-white';
			}
		}

		return $menu;
	}
}