<?php

class WebPage {
    /**
     * @var string Texte compris entre <head> et </head>
     */
    private $head  = null ;
    /**
     * @var string Texte compris entre <title> et </title>
     */
    private $title = null ;
    /**
     * @var string Texte compris entre <body> et </body>
     */
    private $body  = null ;
	/**
     * @var string Texte compris entre <header> et </header>
     */
    private $header  = null ;
	/**
	 * @var le javascript à mettre à la fin du body
	 */
	private $jsEnd = null;

    /**
     * Constructeur
     * @param string $title Titre de la page
     */
    public function __construct($title) {
        $this->setTitle($title) ;
    }

    /**
     * Retourner le contenu de $this->body
     *
     * @return string
     */
    public function body() {
        return $this->body ;
    }

    /**
     * Retourner le contenu de $this->head
     *
     * @return string
     */
    public function head() {
        return $this->head ;
    }
	
	/**
     * Retourner le contenu de $this->header
     *
     * @return string
     */
    public function header() {
        return $this->header ;
    }
	
	/**
     * Retourner le contenu de $this->jsEnd
     *
     * @return string
     */
    public function jsEnd() {
        return $this->jsEnd ;
    }

    /**
     * Donner la dernière modification du script principal
     * @link http://php.net/manual/en/function.getlastmod.php
     * @link http://php.net/manual/en/function.strftime.php
     *
     * @return string
     */
    public function getLastModification() {
        return strftime("Dernière modification de la page le %d/%m/%Y", getlastmod()) ;
    }

    /**
     * Protéger les caractères spéciaux pouvant dégrader la page Web
     * @see http://php.net/manual/en/function.htmlentities.php
     * @param string $string La chaîne à protéger
     *
     * @return string La chaîne protégée
     */
    public static function escapeString($string) {
        return htmlentities($string, ENT_QUOTES|ENT_HTML5, "utf-8") ;
    }

    /**
     * Affecter le titre de la page
     * @param string $title Le titre
     */
    public function setTitle($title) {
        $this->title = $title ;
    }

    /**
     * Ajouter un contenu dans head
     * @param string $content Le contenu à ajouter
     *
     * @return void
     */
    public function appendToHead($content) {
        $this->head .= $content ;
    }
	
	/**
     * Ajouter un contenu dans header
     * @param string $content Le contenu à ajouter
     *
     * @return void
     */
    public function appendToHeader($content) {
        $this->header .= $content ;
    }

    /**
     * Ajouter l'URL d'un script CSS dans head
     * @param string $url L'URL du script CSS
     *
     * @return void
     */
    public function appendCssUrl($url) {
        $this->appendToHead(<<<HTML
    <link rel="stylesheet" type="text/css" href="{$url}">

HTML
) ;
    }

    /**
     * Ajouter un contenu JavaScript dans head
     * @param string $js Le contenu JavaScript à ajouter
     *
     * @return void
     */
    public function appendJs($js) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript'>
    $js
    </script>

HTML
) ;
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans head
     * @param string $url L'URL du script JavaScript
     *
     * @return void
     */
    public function appendJsUrl($url) {
        $this->appendToHead(<<<HTML
    <script type='text/javascript' src='$url'></script>

HTML
) ;
    }
	
	    /**
     * Ajouter un contenu JavaScript dans la fin de body
     * @param string $js Le contenu JavaScript à ajouter
     *
     * @return void
     */
    public function appendJsEnd($js) {
        $this->jsEnd.=<<<HTML
    <script type='text/javascript'>
    $js
    </script>

HTML;
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans la fin de body
     * @param string $url L'URL du script JavaScript
     *
     * @return void
     */
    public function appendJsEndUrl($url) {
        $this->jsEnd.=<<<HTML
    <script type='text/javascript' src='$url'></script>

HTML;
    }
	
	public function addJsEnd($js){
		$this->jsEnd.="\n".$js;
	}

    /**
     * Ajouter un contenu dans body
     * @param string $content Le contenu à ajouter
     *
     * @return void
     */
    public function appendContent($content) {
        $this->body .= $content ;
    }

    /**
     * Produire la page Web complète
     *
     * @return string
     * @throws Exception si title n'est pas défini
     */
    public function toHTML() {
        if (is_null($this->title)) {
            throw new Exception(__CLASS__ . ": title not set") ;
        }

        return <<<HTML
<!doctype html>
<html lang="fr">
    <head>
			  
		<!--Info sur le site-->
		<title>{$this->title}</title>
		<meta charset="utf-8">		
		<!--Ajout webPage-->
		{$this->head()}
    </head>
	
    <body>
		<header> 
			{$this->header()}
		</header> 
		  
        <br><br>

		<section>	
			{$this->body()}
		</section>
		{$this->jsEnd()}
    </body>
</html>
HTML;
    }
}
