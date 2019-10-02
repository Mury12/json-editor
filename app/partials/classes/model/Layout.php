<?php

namespace Model;

class Layout 
{

    private $partials = Array();
    private $page = 'app/pages/hello-world.php';
    private $header = 'app/partials/header.php';
    private $footer = 'app/partials/footer.php';
    private $title = 'Golden Stripe';
    private $head_title = "Golden Stripe";
    private $head_sub_text = "";
    private $head_image = "/assets/img/head-default.png";
    private $meta = Array();
    private $style = Array('/assets/css/main.min.css');
    private $scripts = Array('/assets/pjs/main.min.js');
    private $_env = Array();
    private $nav = "app/partials/navbars/default-menu.php";
    private $nav_enbld = true;
    private $nav_links = Array();
    private $toTopButton = true;
    private $toTopButtonAnchor = 'home';
    private $api = false;
    private $showBody = true;
    private $toBodyButton = true;
    private $access = 'any';
    private $route;

    /**
     * Você pode adicionar mais arquivos css se desejar. Algo específico para cada página.
     * @var f é o diretório com o nome do arquivo, considerando já estar na pasta correta assets/css
     * @example $l->addCss('tema-lindo');
     */
    public function addCss($f) 
    {
        array_push($this->style, '/assets/css/' . $f . '.min.css');
        return $this;
    }

    /**
     * Você pode adicionar mais arquivos .js se desejar, específico para cada página.
     * @var f é o diretório com o nome do arquivo, considerando já estar na pasta correta assets/css
     * @example $l->addJs('js-magnifíco');
     */
    public function addJs($f) 
    {
        array_push($this->scripts, '/assets/pjs/' . $f . '.min.js');
        return $this;
    }

    /**
     * Esta função adiciona as meta-tags, que servem para as plataformas externas capturarem o conteúdo
     * de sua página. 
     * @var name é o nome da meta-tag, @example 'og:description'
     * @var str é o valor da meta-tag, @example 'Um site maravilhoso pra você'
     */
    public function addMeta($name, $str) 
    {
        $this->meta[$name] = $str;
        return $this;
    }

    /**
     * Esta função é responsável por adicionar um título à sua página. Este é o título que aparece na aba do
     * navegador. Para o título do header, consulte @method setHeaderTitle().
     * @var title é seu título
     */
    public function setTitle($title) 
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Esta função adiciona outros arquivos .php em sua página. Pode ser um array de arquivos. 
     * @var files array com os diretórios, já considerando que estão na pasta correta, app/partials.
     * @example $l->appendPartials(['secao-1', 'secao-2', 'secao-3']);
     */
    public function appendPartials($files) 
    {
        foreach ($files as $f) {
            $this->partials[] = 'app/partials' . $f . '.php';
        }
        return $this;
    }

    /**
     * Esta função é responsável por dizer qual é a página a ser carregada no corpo de seu site.
     * @var page é o diretório da página, já considerando estar na pasta correta app/pages.
     * @example $l->setPage('home');
     */
    public function setPage($page) 
    {
        $this->page = 'app/pages/' . $page . '.php';
        return $this;
    }

    /**
     * Este método configura a imagem que aparecerá no cabeçalho de sua página, atrás do título.
     * @var URI é o diretório de sua imagem, considerando estar na pasta correta assets/img
     * @var url valor opcional booleano. Se seu valor for verdadeiro, ele irá considerar o link
     * colocado ao invés da pasta de imagens do projeto.
     */
    public function setHeaderImage($URI, $url = null)
    {
        $url != null ?
        $this->head_image = $URI :
        $this->head_image = '/assets/img/'.$URI;
        return $this;
    }

    /**
     * Este método configura o título do cabeçalho de sua página. Caso você não insira, será utilizado o valor
     * que foi configurado em @var $head_title.
     * @var title é seu título. @example $l->setHeaderTitle('Minha Página Fantástica!');
     */
    public function setHeaderTitle($title)
    {
        $this->head_title = $title;
        return $this;
    }

    /**
     * Este método insere um texto abaixo do título (subtítulo), como uma frase de efeito. É opcional e caso não insira,
     * será deixado em branco.
     * @var text é o seu texto. @example $l->setHeaderSubTitle('Fantástica até para o Johnny ;)')
     */
    public function setHeaderSubTitle($text)
    {
        $this->head_sub_text = $text;
        return $this;
    }

    /**
     * Esta função retorna a imagem de fundo do cabeçalho, inserida em @method setHeaderImage()
     * @return string contendo a imagem.
     */
    public function getHeaderImage(){
        return 'background-image: url(\''.$this->head_image.'\');';
    }        

    /**
     * Esta função retorna o título do cabeçalho, inserido em @method setHeaderTitle()
     * @return string com o título.
     */
    public function getHeaderTitle()
    {
        return $this->head_title;
    }

    /**
     * Este método retorna o texto sob o título, inserido em @method setHeaderSubTitle()
     * @return string com o subtítulo
     */
    public function getHeadersubTitle()
    {
        return $this->head_sub_text;
    }

    /**
     * Este método retorna os arquivos parciais que você inseriu em @method appendPartials()
     * @return file de arquivos
     */
    public function getPartials() 
    {
        return require_once $this->partials;
    }

    /**
     * Este método renderiza a página principal de seu site, configurado em @method setPage()
     * @return file
     */
    public function render() 
    {
        extract($this->getEnv());
        return require_once $this->page;
    }

    /**
     * Este método retorna as meta-tags que você inseriu em @method addMeta()
     * @return array de strings.
     */
    public function getMeta() 
    {
        return $this->meta;
    }

    /**
     * Este método retorna todos os arquivos .js que você inseriu em @method addJs()
     * @return array de strings.
     */
    public function getJs() 
    {
        return $this->scripts;
    }

    /**
     * Este método retorna todos os arquivos .css que você inseriu em @method addCss()
     * @return array de strings.
     */
    public function getCss() 
    {
        return $this->style;
    }

    /**
     * Este método retorna o título que você inseriu em @method setTitle()
     * @return string com o título
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Este método concatena um título ao original já configurado em @method setTitle()
     * @var str título que deseja concatenar
     * @var separator delimitador para separar os títulos
     * @example $l->appendTitle('Página Maravilhosa', '-')
     */
    public function appendTitle($str, $separator) 
    {
        $this->title = $str . " " . $separator . " " . $this->title;
        return $this;
    }

    /**
     * Este método configura o arquivo de cabeçalho de sua página. 
     * @var header é o diretório do arquivo, já considerando estar no local correto, app/partials
     * @example $l->setHeader('header-diferente');
     */
    public function setHeader($header) 
    {
        $this->header = "app/partials/" . $header . '.php';
        return $this;
    }

    /**
     * Este método retorna o cabeçalho que você configurou para a página em @method setHeader()
     * @return file com o header.
     */
    public function getHeader() 
    {
        return require_once $this->header;
    }

    /**
     * Este método configura o arquivo de rodapé de sua página. 
     * @var footer é o diretório do arquivo, já considerando estar no local correto, app/partials
     * @example $l->setHeader('footer-diferente');
     */
    public function setFooter($footer) 
    {
        $this->footer = "app/partials/" . $footer . '.php';
        return $this;
    }
    /** 
     *Este método retorna o rodapé que você configurou para a página em @method setFooter()
     * @return file com o footer.
     */ 
    public function getFooter() 
    {
        return require_once $this->footer;
    }
    
    public function getScripts()
    {
        return require_once('app/partials/pieces/scripts.php');
    }

    /**
     * Este é o método responsável por armazenar as variáveis de ambiente utilizadas dinamicamente nas
     * páginas as quais você as definiu. O vetor é extraído e cada uma de suas chaves é transformada em uma
     * variável diferente para você usar como desejar.
     * @var env vetor de variáveis, devem ter um rótulo.
     * @example $l->setEnv(['motivo' => 'Esta é uma realização!', 'amor' => 'Desenvolver páginas lindas!']);
     * --. Em sua página, basta inserir <?= $motivo ?> e <?= $amor ?> onde quiser e seus valores serão impressos :)
     */
    public function setEnv($env = Array()){
        $this->_env = $env;
        return $this;
    }

    /**
     * Este método é responsável por retornar as variáveis criadas dinamicamente.
     * @return array com as variáveis a serem extraidas.
     */
    public function getEnv()
    {
        return $this->_env;
    }

    /**
     * Esta função é responsável por retornar o caso de o menu de navegação estar ou não ativo,
     * como definido em @method disableNav()
     * @return boolean 
     */
    public function isNavEnabled()
    {
        return $this->nav_enbld;
    }

    /**
     * Este método desabilita o menu de navegação.
     */
    public function disableNav()
    {
        $this->nav_enbld = false;
        return $this;
    }

    /**
     * Este método configura qual menu de navegação será utilizado
     * @var file diretório com nome do arquivo, considerando já estar na pasta correta /app/partials/navbars
     * @example $l->setNavbar('menu-lindo');
     */
    public function setNavbar($file)
    {
        if($file != null)
            $this->nav = "app/partials/navbars/" . $file . '.php';
        return $this;
    }

    /**
     * Esta função retorna o arquivo contendo a barra de navegação inserida em @method setNavbar()
     * @return file arquivo da navbar
     */
    public function getNav()
    {
        return require_once $this->nav;
    }

    /**
     * Use esta função para adicionar itens nos menus de navegação dinâmicos, como o list-section-menu
     * @var name nome do ítem que aparecerá no menu
     * @var link link destino do ítem
     * @example $l->addItemsToNavbar('Página da Beleza', '/pagina-beleza')
     */
    public function addItemsToNavbar($name, $link)
    {
        $item['name'] = $name;
        $item['link'] = $link;
        $this->nav_links[] = $item;
        return $this;
    }
    /**
     * Esta função retorna os itens adicionados ao menu no esquema citado em @method addItemsToNavbar()
     * @return array com os itens
     */
    public function getExtraNavItems()
    {
        return $this->nav_links;
    }

    /**
     * Esta função é responsável por determinar se o botão que leva de volta ao topo
     * estará ativo na página. True é definido como padrão.
     * @var enable false para desativar.
     */
    public function toTopButton($enable){
        $this->toTopButton = $enable;
        return $this;
    }

    /**
     * Retorna se o botão de link para o topo da página está ativo
     * @return boolean
     */
    public function isToTopButtonEnabled(){
        return $this->toTopButton;
    }

    /**
     * Esta função é responsável por definir o ID ao qual se refere ao topo da página. 'home' é definido como
     * padrão.
     * @var anchor ID do elemento
     * @example $l->toTopButtonAnchor('home');
     */
    public function toTopButtonAnchor($anchor){
        $this->toTopButtonAnchor = $anchor;
        return $this;
    }

    /**
     * Retorna a âncora definida ao botão que leva para o topo da página.
     */
    public function getToTopButtonAnchor(){
        return $this->toTopButtonAnchor;
    }

    /**
     * Configura a página como uma página de requisições.
     */
    public function isApi($bool = false){
        if($bool){
            $this->api = true;
        }
        return $this->api;
    }

    /**
     * Esconde o corpo da página, caso queira mostrar apenas o cabeçalho, como na página de cadastro.
     */
    public function showBody($bool){
        $this->showBody = $bool;
        return $this;
    }

    /**
     * Retorna o estado do corpo da página, se é exibido ou não.
     */
    public function isBodyEnabled(){
        return $this->showBody;
    }

    /**
     * Configura a exibição do botão que leva ao corpo da página
     */
    public function showToBodyButton($bool){
        $this->toBodyButton = $bool;
        return $this;
    }

    /**
     * Retorna o estado o botão que leva ao corpo da página
     */
    public function isBodyButtonEnabled(){
        return $this->toBodyButton;
    }

    /**
     * Configura o tipo de usuário que pode acessar a página, sendo 'auth' para somente autenticado,
     * 'any' para todos os usuários (padrão) e 'not' para somente usuários não autenticados.
     */
    public function permission($level){
        $this->access = $level;
        return $this;
    }

    /**
     * Retorna o estado da necessidade de autenticação de uma página.
     */
    public function getAccessLevel(){
        return $this->access;
    }

    public function setRouteName($route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRouteName()
    {
        return $this->route;
    }

    /**
     * Retorna o conteúdo de um arquivo localizado em 'app/partials/pieces' podendo ser integrado em outra
     * página.
     * @var file nome do arquivo sem extensão.
     * @return string com o conteúdo do arquivo.
     */
    public function getFilePartial($file)
    {
        return \file_get_contents('app/partials/pieces/'.$file.'.php');
    }

}
