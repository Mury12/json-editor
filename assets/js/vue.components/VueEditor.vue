<template>

    <div class="row" id="table">
        <div class="col-12">
            <div class="row">
                <form @submit="save($event)" ref="form1">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label class="w-100">Número da Conta* <br/>
                            <input type="text" class="form-control" v-model="item.account_freed" placeholder="Numero da conta" required>
                            </label><br/>
                            <label class="w-100">Nome da conta* <br/>
                            <input type="text" class="form-control" v-model="item.owner_name" placeholder="Nome da conta" required>
                            </label><br/>
                            <label class="w-100">Número do Robô* <br/>
                            <input type="text" class="form-control" v-model="item.robot_number" placeholder="Número do robô" required>
                            </label>
                            <label class="w-100">Código da Plataforma* <br/>
                            <input type="text" class="form-control" v-model="item.platform_code" placeholder="1234" required>
                            </label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="w-100">Data de Término*<br/>
                            <input type="date" class="form-control" v-model="item.expires_at" placeholder="Data de término" required>
                            </label><br/>
                            <label class="w-100" v-if="item.editing">Data de Término de Renovação*<br/>
                            <input type="date" class="form-control" v-model="item.renew_expires_at" placeholder="Data de término renovação">
                            </label><br/>
                            <label class="w-100">Observações<br/>
                            <input type="text" class="form-control" v-model="item.comment" placeholder="Observações"><br/>
                            </label>
                        </div>
                    </div>
                    <button
                        class="btn btn-success"
                        type="submit" 
                    >Salvar</button>
                    <button 
                        v-if="item.editing"
                        @click="editCancel"
                        class="btn btn-info"
                        type="button"
                    >Cancelar edição</button>
                </form>
            </div>
            <div class="row" >
                <vue-table :items="items"
                    @delete ="handleDelete($event)"
                    @edit   ="handleEdit($event)"
                    :editing='item.curIdx'
                ></vue-table>
            </div>
        </div>
    </div>

</template>

<script>
import VueTable from "./VueTable.vue";

    module.exports = {
        data: function () {
            return {
                auth: false,
                issues: [],
                item: {
                    account_freed: '',
                    owner_name: '',
                    robot_number: '',
                    expires_at: '',
                    renew_expires_at: '',
                    platform_code: '',
                    comment: '',
                    editing: false,
                    curIdx: -1
                },
                items: []
            }
        },
        components: {
            VueTable
        },
        methods: {
            load: function(){},

            save: function(e)
            {
                e.preventDefault();

                if(!this.validateForm()) {
                    let issues = this.issues.join(', ');
                    simpleAlert.show({
                        message: `Preencha os campos ${issues} corretamente.`
                    })
                    return false;
                }
                this.do(this.item, this.item.editing)
            },

            do: function(data, editing)
            {
                let operation = editing ? 'change_json' : 'save_json';
                return perform.post(config.api.robot.put, operation, data)
                    .then(r => {
                    if(r.res == 'OK'){

                        setTimeout(f => {
                            simpleAlert.show({
                                message: `Item ${this.item.account_freed} salvo com sucesso.`,
                                type: 'success'
                            })
                            this.editCancel();    
                            this.getItems();
                        }, 1000)
                    }else{
                        simpleAlert.show({
                            message: `Houve um problema ao salvar ${this.item.account_freed}. Por favor, tente novamente.`,
                            ttl: 5000
                        })
                    }
                })  
            },

            validateForm: function() {
                this.issues.splice(0, this.issues.length);
                this.item.account_freed.length < 1  ? this.issues.push('Conta')      : null
                this.item.platform_code.length < 1  ? this.issues.push('Plataforma') : null
                this.item.owner_name.length    < 3  ? this.issues.push('Nome')       : null
                this.item.robot_number.length  < 1  ? this.issues.push('Robô')       : null
                this.item.expires_at.length    < 10 ? this.issues.push('Data de Termino') : null

                if(this.issues.length == 0) return true

                return false;

            },
            handleDelete: function(e)
            {
                this.delItem(e);
            },

            handleEdit: function(e) 
            {
                this.editCancel();
                this.item = this.items[e];
                this.item.owner_name = this.item.owner.owner_name || '';
                this.item.platform_code = this.item.platform.platform_code || '';
                this.item.editing = true;
                this.item.curIdx  = e;
            },

            editCancel: function()
            {
                let bak = this.items.splice();
                bak.forEach(el => {
                    this.item.push(el);
                })
                this.item.editing = false;
                this.item.curIdx  = -1;
            },
            delItem: function(e)
            {
                perform.post(config.api.robot.put, 'del_item', {item_id: this.items[e].order_id})
                .then(r => {
                    if(!r.err){
                        this.items.splice(e, 1);
                        simpleAlert.show({
                            message: r.res,
                            type: 'success'
                        })
                    }else{
                        simpleAlert.show({
                            message: r.res,
                        })
                    }
                })
            },
            getItems: function()
            {
                return perform.post(config.api.robot.get,'get_json')
                .then(r => {
                    if(r) this.items = r
                })
            }
        },
        created: function(){
            this.getItems();
        }

    }
</script>