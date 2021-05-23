<template>
    <app-layout title="Пользователи">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item disabled>
                Пользователи
            </v-breadcrumbs-item>
        </template>
        <v-card>
            <v-card-title>Панель управления пользователями</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <span v-if="can.manageUsers">
                    Для смены роли пользователя нажмите на его роль, после чего появится диалоговое окно.
                </span>
                <span v-else>
                    Смена роли пользователей доступна только администраторам.
                </span>
                <v-btn
                    class="mb-1"
                    color="primary"
                    @click="$inertia.get(route('users.create'))"
                    v-if="can.manageUsers"
                >
                    Создать пользователя
                </v-btn>
            </v-card-text>
        </v-card>
        <v-card class="mt-5">
            <v-card-title>
                Пользователи
                <v-spacer></v-spacer>
                <v-text-field
                    class="font-weight-regular col-sm-6 col-md-3"
                    v-model="search"
                    append-icon="mdi-magnify"
                    @click:append="filterByName"
                    @keyup.enter="filterByName"
                    label="Поиск"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="users.data"
                :server-items-length="users.meta.total"
                :items-per-page="users.meta.per_page"
                :options.sync="options"
                :page="users.meta.current_page"
                class="col-12 mt-5"
                :disable-sort="true"
                @update:page="changePage"
                :loading="loading"
                :footer-props="{
                    showFirstLastPage: true,
                    disableItemsPerPage : true,
                    itemsPerPageText: 'Кол-во на странице: ',
                }"
                no-data-text="Пользователей не найдено"
            >
                <template v-slot:item.role="{ item }">
                    <div @click="can.manageUsers ? openModal(item.id, item.role) : false">
                        <RoleChip :key="item.role" :role="item.role"></RoleChip>
                    </div>
                </template>
            </v-data-table>
        </v-card>
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
        'sortingRoles',
        'filters',
        'can'
    ],
    components: {
        ChangeRoleDialog,
        RoleChip,
        AppLayout
    },
    data () {
        return {
            search: this.filters.filter.full_name,
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
            this.$inertia.get(this.users.meta.links[pagination].url, {}, {
                preserveScroll: true,
                onSuccess: () => this.loading = false
            })
        },
        openModal (id, role) {
            EventBus.$emit('openModalChangeRoleDialog', {
                userId: id,
                currentRole: role
            })
        },
        filterByName () {
            this.loading = true
            this.$inertia.get(route('users.index'), {
                'filter[full_name]': this.search
            }, {
                onSuccess: () => this.loading = false
            })
        }
    }
}
</script>
