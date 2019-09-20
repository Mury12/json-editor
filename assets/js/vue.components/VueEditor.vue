<template>

    <div class="row" id="table">
        <div class="col-12">
            <div class="row">
                <form @submit="save($event)">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control" v-model="item.conta" placeholder="Numero da conta">
                            <input type="text" class="form-control" v-model="item.nome" placeholder="Nome da conta">
                            <input type="text" class="form-control" v-model="item.robo" placeholder="Valor do robô">
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control" v-mask="['% ##/##/####']" v-model="item.termino" placeholder="Data de término">
                            <input type="text" class="form-control" v-mask="['* ##/##/####']" v-model="item.term_renovacao" placeholder="Data de término renovação">
                            <input type="text" class="form-control" v-model="item.observacao" placeholder="Observações"><br/>
                        </div>
                    </div>
                    <button
                        class="btn btn-success"
                        type="submit" 
                    >Salvar</button>
                </form>
            </div>
            <div class="row" >
                <vue-table :items="items"
                    @delete ="handleDelete($event)"
                    @edit   ="handleEdit($event)"
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
                    conta: '',
                    nome: '',
                    robo: '',
                    termino: '',
                    term_renovacao: '',
                    observacao: '',
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
                let data = this.items;
                data.push(this.item);
                $.post('api/json/save', {
                    exec: 'save_json',
                    data: data
                }).then(r => {
                    if(r.res == 'OK'){

                        this.getItems()
                        simpleAlert.show({
                            message: `Item ${this.item.conta} salvo com sucesso.`,
                            type: 'success'
                        })

                        this.item.forEach(el => {
                            el = ''
                        });   
                    }else{
                        simpleAlert.show({
                            message: `Houve um problema ao salvar ${this.item.conta}. Por favor, tente novamente.`,
                            ttl: 5000
                        })
                    }
                })
            },
            validateForm: function() {
                this.issues.splice(0, this.issues.length);
                this.item.conta.length < 4 ? this.issues.push('Conta') : null
                this.item.nome.length  < 3 ? this.issues.push('Nome')  : null
                this.item.robo.length  < 2 ? this.issues.push('Robô')  : null
                this.item.termino.length < 12 ? this.issues.push('Data de Termino') : null
                this.item.term_renovacao.length < 12 ? this.issues.push('Data de Termino de Renovação') : null

                if(this.issues.length == 0) return true

                return false;

            },
            handleDelete: function(e)
            {
                this.items.splice(e, 1);
                this.save()
            },
            handleEdit: function(e) 
            {
                this.item = this.items[e];
                this.items.splice(e, 1);
            },
            getItems: function()
            {
                $.post('api/json/save', {
                    exec: 'get_json'
                }).then(r => {
                    this.items = r
                })
            }
        },
        created: function(){
            this.getItems();
        }

    }
</script>