
<div class="modal fade login-task" tabindex="-1" role="dialog" id="login_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Entrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <form class="t-white text-left" @keyup.enter="login">
                            <label>Seu e-mail:<br />
                                <input type="text" v-model="username" placeholder="Nome de usuário">
                            </label>

                            <label>Sua senha:<br />
                                <input type="password" v-model="pwd" placeholder="Sua senha">
                            </label><br />
                            <button type="button" class="btn btn-block m-0 btn-success" @click="login">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
