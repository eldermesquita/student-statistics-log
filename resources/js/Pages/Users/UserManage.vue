<template>
    <app-layout>
        <v-card>
            <v-card-subtitle class="font-weight-medium">Панель управления пользователями</v-card-subtitle>
        </v-card>
        <v-data-table
            :headers="headers"
            :items="users.data"
            :server-items-length="users.pagination.total"
            :options.sync="options"
            :page="users.pagination.current"
            class="elevation-1 col-12 mt-5"
            :disable-sort="true"
            @update:page="changePage"
            :loading="loading"
            :footer-props="{
                showFirstLastPage: true,
                disableItemsPerPage : true,
                itemsPerPageText: 'Кол-во на странице: '
            }"
        >
            <template v-slot:item.role="{ item }">
                <RoleChip :role="item.role"></RoleChip>
            </template>
        </v-data-table>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import RoleChip from "./RoleChip";

export default {
    props: [
        'users',
    ],
    components: {
        RoleChip,
        AppLayout
    },
    methods: {
        changePage(pagination) {
            this.loading = true;
            this.$inertia.get(route('users.index'), {
                page: pagination
            }, {
                onSuccess: () => this.loading = false
            })
        }
    },
    data () {
        return {
            loading: false,
            options: {},
            headers: [
                {
                    text: 'Фамилия',
                    value: 'surname',
                },
                {
                    text: 'Имя',
                    value: 'name',
                },
                {
                    text: 'Отчество',
                    value: 'patronymic',
                },
                {
                    text: 'Роль',
                    value: 'role',
                },
                {
                    text: 'Последняя активность',
                    value: 'session.last_activity'
                },
                {
                    text: 'Ip адрес',
                    value: 'session.ip_address'
                }
            ]
        }
    }
}
</script>
