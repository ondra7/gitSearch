<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Application\UI\Form;

use Nette\Utils\Json;
use Nette\Utils\JsonException;


class SearchPresenter extends Nette\Application\UI\Presenter
{
	private $cache;
    
    public function __construct(\Nette\Caching\Cache $cache){
		$this->cache = $cache;
	}
	// Get and load json
	public function getJson($name)
	{
		$json = $this->cache->load('git_users_'.$name);
		if ($json === NULL) 
		{
			$opts = ['http' => ['method' => 'GET', 'header' => ['User-Agent: PHP']]];
			$context = stream_context_create($opts);
			$json = file_get_contents('https://api.github.com/users/'.$name.'/repos?sort=created', false, $context);
			$json = Json::decode($json);
			$this->cache->save('git_users_'.$name, $json);
		}
		
		$obj = (object)[];

		$key = 0;
		foreach ($json as $item)
		{
			$obj->$key = (object)[];
			$obj->$key->id = $item->id;
			$obj->$key->name = $item->name;
			$obj->$key->full_name = $item->full_name;
			$obj->$key->html_url = $item->html_url;
			$obj->$key->created_at = $item->created_at;
			$obj->$key->updated_at = $item->updated_at;
			$obj->$key->size = $item->size;
			$key++;
		}
		return $obj;
	}
	
	public function renderShow($name)
	{
		$items = $this->getJson($name);
		$this->template->items = $items;
	}
}
