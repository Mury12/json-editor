<template>
    <div class="client-scrap col-12">
        
        <table class="text-center table table-stripped table-hover w-100">
            <thead>
                <th>Contas</th>
                <th>Nome</th>
                <th>Nº do Robô</th>
                <th>Data Término</th>
                <th>Data Término Renovação</th>
                <th>Observações</th>
                <th>Ação</th>
            </thead>
            <tr v-for="(item, idx) in items" :key="idx">
                <td>{{item.conta}}</td>
                <td>{{item.nome}}</td>
                <td>{{item.robo}}</td>
                <td>{{item.termino}}</td>
                <td>{{item.term_renovacao}}</td>
                <td>{{item.observacao}}</td>
                <td>
                    <button class="btn btn-success"
                        @click="$emit('edit', idx)"
                    >
                        <i class="far fa-edit  " style="cursor: pointer"></i>
                    </button>
                    <button class="btn btn-danger"
                        @click="$emit('delete', idx)"
                    >
                        <i class="fas fa-trash " style="cursor: pointer"></i>
                    </button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    module.exports = {
        data: function () {
            return {
                idx: '',
            }
        },
        props: [
            'items'
        ]
    }
</script>