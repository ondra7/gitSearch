<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Application\UI\Form;


class HomepagePresenter extends BasePresenter
{
	private $database;
	
	// Connect to db
	public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
    
    // Show form
    protected function createComponentCommentForm()
	{
		$form = new Form;
		$form->addText('name', 'Jméno git uživatele:')
			->setRequired();
		$form->addSubmit('send', 'Vyhledat');
		
		$form->onSuccess[] = [$this, 'searchSucceeded'];
		return $form;
	}
	
	// Store log to db
	public function storeLog($text, $ip)
	{
		$this->database->table('searchLog')->insert([
			'text' => $text,
			'ip' => $ip
		]);
	}
	
	// On search success
	public function searchSucceeded($form, $values)
	{
		$postId = $this->getParameter('postId');
		$ipAddress = $this->getHttpRequest()->getRemoteAddress();
		$name = $values->name;
		
		$this->storeLog($name, $ipAddress);

		$this->redirect('Search:Show', array("name" => $name));
	}

	// Default render
	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
