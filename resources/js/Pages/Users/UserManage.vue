<template>
    <app-layout title="Пользователи">
        <v-card>
            <v-card-title>Панель управления пользователями</v-card-title>
            <v-card-text>
                <span v-if="can.manageUsers">
                    Для смены роли пользователя нажмите на его роль, после чего появится диалоговое окно.
                </span>
                <span v-else>
                    Смена роли пользователей доступна только администраторам.
                </span>
            </v-card-text>
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
                <div @click="can.manageUsers ? openModal(item.id, item.role) : false">
                    <RoleChip :key="item.role" :role="item.role"></RoleChip>
                </div>
            </template>
        </v-data-table>
        <ChangeRoleDialog :roles="roles"></ChangeRoleDialog>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import RoleChip from "../Shared/Users/RoleChip";
import ChangeRoleDialog from "../Shared/Users/ChangeRoleDialog";
import { EventBus } from "@/event-bus.js";

export default {
    props: [
        'users',
        'roles',
        'can'
    ],
    components: {
        ChangeRoleDialog,
        RoleChip,
        AppLayout
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
    },
    methods: {
        changePage(pagination) {
            this.loading = true;
            this.$inertia.get(route('users.index'), {
                page: pagination
            }, {
                onSuccess: () => this.loading = false
            })
        },
        openModal (id, role) {
            EventBus.$emit('openModalChangeRoleDialog', {
                userId: id,
                currentRole: role
            })
        },
    }
}
</script>
