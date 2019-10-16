var response;
var login = {
    username: '',
    pwd: '',
}
var vLn = new Vue({
    el: '#login_modal',
    data: login,

    methods: {
        login: function(){
            if(this.username.length <= 0) return simpleAlert.show({message: 'Precisa preencher seu e-mail!'}); else
            if(this.pwd.length < 4) return simpleAlert.show({message: 'Você precisa preencher sua senha!'});

            else
            {
                perform.post(config.api.user.login, 'login', login).then(function(r){
                    if(!r.err) {
                        response = {message: r.res, alertType: 'success'};
                        $('#login_modal').modal('hide');
                        vLo.isAuthenticated();
                        location.href="adm-golden/robos";
                    } else
                    if(r.err) response = {message: r.res, alertType: 'warn'};
                    
                    simpleAlert.show({
                        message: response.message,
                        type: response.alertType
                    });
                });

            }
            
        },

    },
    created: function(){
        setTimeout(f => {
            if(!logout.auth){
                $('#login_modal').modal('show');
            }
        },2000)
    }
});

var logout = {
    execution: '',
    auth: auth,
}
var vLo = new Vue({
    el: '#login_btns',
    data: logout,
    methods: {
        logOut: function(){
            perform.post(config.api.user.login, 'logout').then(function(r){
                simpleAlert.show({
                    message: r.res,
                    type: 'warn'
                });
                location.href="/adm-golden";
                vLo.isAuthenticated();
            });
            
        },
                
        regAuth: function(r){
            this.auth = r.res;
            auth = r.res;
        },
        
        isAuthenticated: function(){
            perform.post(config.api.user.login, 'is_logged_in').then(function(r){
                vLo.regAuth(r)
            });
        },

    },
    created: function(){
        this.isAuthenticated();
    }
});
