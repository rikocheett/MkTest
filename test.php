<?php
/*
	task
	1. Напишите функцию подготовки строки, которая заполняет шаблон данными из указанного объекта
	2. Пришлите код целиком, чтобы можно его было проверить
	3. Придерживайтесь code style текущего задания
	4. По необходимости - можете дописать код, методы
	5. Разместите код в гите и пришлите ссылку
*/

/**
 * Класс для работы с API
 *
 * @author		Aleksandr Zaitsev
 * @version		v.1.0 (13/07/2025)
 */
class Api
{
	public function __construct()
	{
	
	}


	/**
	 * Заполняет строковый шаблон template данными из объекта object
	 *
	 * @author		Aleksandr Zaitsev
	 * @version		v.1.0 (13/07/2025)
	 * @param		array $array
	 * @param		string $template
	 * @return		string
	 */
	public function get_api_path(array $array, string $template) : string
	{
		$result = $template;

		foreach ($array as $key => $el) 
		{
			/**
			* Без конструкции if тоже будет работать, но с ней наглядней, 
			* тк явно изменяем состояние переменной $result, лишь когда нашли нужный $key
			*/
			if (str_contains($result, "%$key%")) 
			{
				$result = str_replace("%$key%", rawurlencode($el), $result);
			}
		}
		return $result;
	}
}

$user =
[
	'id'		=> 20,
	'name'		=> 'John Dow',
	'role'		=> 'QA',
	'salary'	=> 100
];

$api_path_templates =
[
	"/api/items/%id%/%name%",
	"/api/items/%id%/%role%",
	"/api/items/%id%/%salary%"
];

$api = new Api();

$api_paths = array_map(function ($api_path_template) use ($api, $user)
{
	return $api->get_api_path($user, $api_path_template);
}, $api_path_templates);

echo json_encode($api_paths, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

$expected_result = ['/api/items/20/John%20Dow','/api/items/20/QA','/api/items/20/100'];

echo ($expected_result === $api_paths) ? PHP_EOL . 'Success!' : PHP_EOL . 'Flail!';
