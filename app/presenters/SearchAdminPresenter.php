<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


class SearchAdminPresenter extends Nette\Application\UI\Presenter
{
	private $database;

	// Connect to db
	public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
	
	protected function createComponentPostForm()
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->error('Pro vymazání záznamů se musíte přihlásit.');
		}
		$form = new Form;
		$form->addText('hours', 'Starší n a více hodin:')
			->setRequired();

		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = [$this, 'postFormSucceeded'];

		return $form;
	}
	
	public function postFormSucceeded($form, $values)
	{
		if (!$this->getUser()->isLoggedIn()) {
			$this->error('Pro vymazání záznamů se musíte přihlásit.');
		}
		$items = $this->database->table('searchLog')
			->where('time <= NOW( ) - INTERVAL '.$values->hours.' HOUR')
			->order('time DESC')
			->delete();
		if ($items > 0) $this->flashMessage('Záznamy vymazány - '.$items, 'success');
		else $this->flashMessage('Žádné záznamy k vymazání', 'success');
	}

}
