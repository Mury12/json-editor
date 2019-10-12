<template>
    <div class="client-scrap col-12">
        
        <table class="text-center table table-stripped table-hover w-100" v-if="items.length">
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
                <td>{{item.account_freed}}</td>
                <td>{{item.owner.owner_name != 'undefined' ? item.owner.owner_name : '' }}</td>
                <td>{{item.robot_number}}</td>
                <td>{{item.expires_at}}</td>
                <td>{{item.renew_expires_at || '--'}}</td>
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
        <h4 v-else class="text-center">
            Nada para mostrar. Tente adicionar algum registro para começar.
        </h4>
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