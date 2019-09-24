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
        'adm-golden/robos' => 
                $l = new Layout,
                $l->setPage('json-admin')
                ->appendTitle('Administração', "|")
                ->setHeaderTitle($l->getFilePartial('header-logo'))
                ->setHeaderSubTitle($l->getFilePartial('header-ad'))
                ->addJs("home")
                ->permission('auth')
        ,
        '8c6976e5b5410415bde908bd4dee15d'=>
                $l = new Layout,
                $l->setPage('api/get-json-os')
                ->permission('any')
                ->isApi(true)
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
