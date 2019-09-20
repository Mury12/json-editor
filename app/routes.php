        <?php
        /**
         * Aqui é onde as rotas são definidas e retornadas para o layout. Siga as instruções corretamente para que possa
         * definir suas rotas da melhor forma.
         */
        use Model\Layout;

        require_once 'partials/classes/model/Layout.php';

        return [

        '' =>
            $l = new Layout,
                $l->appendTitle('Home', "|")
                ->setPage('home')
                ->setHeaderTitle($l->getFilePartial('header-logo'))
                ->setHeaderSubTitle($l->getFilePartial('header-ad'))
                ->permission('not')
                ->addJs("home")
        ,
        'json-manager' => 
                $l = new Layout,
                $l->setPage('json-admin')
                ->setHeaderTitle($l->getFilePartial('header-logo'))
                ->setHeaderSubTitle($l->getFilePartial('header-ad'))
                ->addJs("home")
                ->permission('auth')
        ,
        'api/usr/login' =>
                $l = new Layout,
                $l->setPage('api/usr/login')
                ->isApi(true)
        ,
        'api/json/save' => 
                $l = new Layout,
                $l->setPage('api/json-save')
                ->permission('auth')
                ->isApi(true)
        ,
        'api/getUniqId' =>
                $l = new Layout,
                $l->setPage('api/uniqid_gen')
                ->isApi(true)
        ,
        'error/404' =>
                $l = new Layout,
                $l->setPage('errors/404')
        ,

        ];
