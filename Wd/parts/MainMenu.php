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
		return $menu;
	}
}