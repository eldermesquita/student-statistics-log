<template>
    <app-layout title="Создание нового предмета">
        <v-card class="mb-5">
            <v-card-title>Создание нового предмета</v-card-title>
            <v-card-text>
                <span>
                    Признак активности предмета влияет на появление его в списках к созданию АКР.
                </span>
            </v-card-text>
        </v-card>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <v-form @submit.prevent="create">
                            <v-text-field
                                v-model="form.title"
                                label="Название"
                                required
                                type="text"
                                :error-messages="errors.title"
                            ></v-text-field>
                            <span>Для того чтобы назначить преподавателей на этот предмет просто начните вводить его ФИО</span>
                            <v-autocomplete
                                v-model="form.teachers"
                                :items="users"
                                :search-input.sync="search"
                                chips
                                clearable
                                color="blue-grey lighten-2"
                                label="Назачить перподавателей"
                                item-text="abbreviated_name"
                                item-value="id"
                                multiple
                                :loading="loadingUsers"
                                no-data-text="Начните вводить ФИО преподавателя"
                                @input="search = ''"
                                deletable-chips
                                :error-messages="errors.teachers"
                            >
                            </v-autocomplete>
                            <span class="error--text d-block">
                                Внимание! В списке отображаются только пользователи с правами Администратора, либо Учителя!
                            </span>
                            <v-btn
                                type="submit"
                                class="mt-3"
                                color="primary"
                                :loading="form.processing"
                                :disabled="form.processing"
                            >
                                Сохранить
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import Pagination from "../Shared/Pagination/Pagination";
import RoleChip from "../Shared/Users/RoleChip";
import _ from 'lodash';

export default {
    props: [
        'course',
        'errors'
    ],
    components: {
        RoleChip,
        Pagination,
        AppLayout
    },
    data () {
        return {
            users: [],
            search: null,
            loadingUsers: false,
            form: this.$inertia.form({
                title: '',
                teachers: []
            })
        }
    },
    watch: {
        search: _.debounce(function(value) {
            if (value && value.length > 0) {
                this.fetchUsers({
                    'filter[full_name]': value,
                })
            }
        }, 500)
    },
    methods: {
        fetchUsers (filters) {
            this.loadingUsers = true
            axios.get('/users/workers', {
                params: filters
            }).then(
                response => {
                    this.users = _.unionBy(this.users, response.data.data, 'id')
                }
            ).finally(() => (this.loadingUsers = false))
        },
        create () {
            this.form.post(route('courses.store'))
        }
    }
}
</script>
