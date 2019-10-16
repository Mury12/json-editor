        <?php
        /**
         * Rotas de API, modelos:
         * ws/v2/nome-do-serviço/serviço
         */
        use Model\Layout;

        require_once 'partials/classes/model/Layout.php';
        $prefix = __WS_ROUTE_PREFIX__;
        return [

        '8c6976e5b5410415bde908bd4dee15d'=>
                $l = new Layout,
                $l->setPage('api/get-json-os')
                ->permission('any')
                ->isApi(true)
        ,       
        __WS_ROUTE_PREFIX__.'usr/login' =>
                $l = new Layout,
                $l->setPage('api/usr/login')
                ->isApi(true)
        ,
        __WS_ROUTE_PREFIX__.'r/put' => 
                $l = new Layout,
                $l->setPage('api/json-save')
                ->permission('auth')
                ->isApi(true)
        ,
        __WS_ROUTE_PREFIX__.'r/get' => 
                $l = new Layout,
                $l->setPage('api/json-save')
                ->permission('auth')
                ->isApi(true)
        ,
        __WS_ROUTE_PREFIX__.'getUniqId' =>
                $l = new Layout,
                $l->setPage('api/uniqid_gen')
                ->isApi(true)
        ,

        ];
