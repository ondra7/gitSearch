<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Application\UI\Form;


class SearchLogPresenter extends BasePresenter
{
	private $database;
	private $totalPosts;
	
	// Connect to db
	public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

	// Default render
	public function renderDefault($page = 1)
	{
		$paginator = new Nette\Utils\Paginator;
		$paginator->setItemsPerPage(5); 
		$paginator->setPage($page);
		
		$items = $this->database->table('searchLog')
			->order('time DESC')
			->limit($paginator->getLength(), $paginator->getOffset());
			
		$this->totalPosts = $this->database->table('searchLog')->count();
		$paginator->setItemCount($this->totalPosts);
		
		$this->template->items = $items;
		$this->template->totalPosts = $paginator->getPageCount();
		$this->template->page = $paginator->page;
	}

}
