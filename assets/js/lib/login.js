var response;
var login = {
    execution: '',
    email: '',
    pwd: '',
}
var vLn = new Vue({
    el: '#login_modal',
    data: login,

    methods: {
        login: function(){
            if(this.email.length <= 0) return simpleAlert.show({message: 'Precisa preencher seu e-mail!'}); else
            if(this.pwd.length < 4) return simpleAlert.show({message: 'Você precisa preencher sua senha!'});

            else
            {
                this.execution = 'login_execute';
                $.post('/api/usr/login', login, null, 'json').then(function(r){
                    if(!r.err) {
                        response = {message: r.res, alertType: 'success'};
                        $('#login_modal').modal('hide');
                        vLo.isAuthenticated();
                        location.href="json-manager";
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
    auth: auth
}
var vLo = new Vue({
    el: '#login_btns',
    data: logout,
    methods: {
        logOut: function(){
            $.post('/api/usr/login', {
                execution: 'logout_execute' 
            }, null, 'json').then(function(r){
                simpleAlert.show({
                    message: r.res,
                    type: 'warn'
                });
                location.href="/";
                vLo.isAuthenticated();
            });
            
        },
                
        regAuth: function(r){
            this.auth = r.res;
            auth = r.res;
        },
        
        isAuthenticated: function(){
            $.post('/api/usr/login', {
                execution: 'is_logged_in'
            }, function(r){
                vLo.regAuth(r)
            }, 'json')
        },

    },
    created: function(){
        this.isAuthenticated();
    }
});
