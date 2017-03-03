# gitSearch
Jednoduchý vyhledávač v git repozitářích založený na PHP/Nette.

Instalace a nastavení
---------------------

Pro provoz je potřeba PHP 5.6 a vyšší.

Po stažení se ujistěte, že do složek "temp/" a "log/" lze zapisovat.

Nastavení přístupu do databáze - soubor "/app/config/config.neon" - přidat na konec:
	
	database:
		dsn: 'mysql:host=localhost;dbname=***'
		user: ***
		password: ***
		options:
			lazy: yes
		
V databázi je třeba vytvořit tabulku, která bude sloužit k logování hledání:

	CREATE TABLE IF NOT EXISTS `searchLog` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `ip` varchar(20) NOT NULL,
	  `text` text NOT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `id_2` (`id`),
	  KEY `id` (`id`),
	  KEY `id_3` (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0		


Je potřeba mít aktivní mod_rewrite a v případě potřeby upravit soubor www/.htaccess:

	RewriteEngine On
	RewriteBase /


Nastavení stránkování v sekci "Seznam hledání":

	soubor "app/presenters/SearchLogPresenter.php" 
	řádek 25 - $paginator->setItemsPerPage(5); 

Nastavení jména a hesla:

	/app/config/config.neon
	security:
		users:
			admin: secret

Bezpečnostní varování a rady viz - https://nette.org/security-warning
