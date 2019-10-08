        <?php
        /**
         * Aqui é onde as rotas são definidas e retornadas para o layout. Siga as instruções corretamente para que possa
         * definir suas rotas da melhor forma.
         */
        use Model\Layout;

        require_once 'partials/classes/model/Layout.php';

        return [

        'adm-golden' =>
            $l = new Layout,
                $l->appendTitle('Login', "|")
                ->setPage('home')
                ->setHeaderTitle($l->getFilePartial('header-logo'))
                ->setHeaderSubTitle($l->getFilePartial('header-ad'))
                ->permission('not')
                ->addJs("home")
        ,
        __ROOT_ROUTE_PREFIX__.'robos' => 
                $l = new Layout,
                $l->setPage('json-admin')
                ->appendTitle('Administração', "|")
                ->setHeaderTitle($l->getFilePartial('header-logo'))
                ->setHeaderSubTitle($l->getFilePartial('header-ad'))
                ->addJs("home")
                ->permission('auth')
        ,
        
        'error/404' =>
                $l = new Layout,
                $l->setPage('errors/404')
        ,

        ];
