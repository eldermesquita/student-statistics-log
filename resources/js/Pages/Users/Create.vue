<template>
    <app-layout title="Создание нового пользователя">
        <v-card class="mb-5">
            <v-card-title>Создание нового пользователя</v-card-title>
        </v-card>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <v-form ref="createForm" @submit.prevent="create">
                            <v-text-field
                                v-model="form.name"
                                label="Имя"
                                required
                                type="text"
                                :error-messages="errors.name"
                            ></v-text-field>
                            <v-text-field
                                v-model="form.surname"
                                label="Фамилия"
                                required
                                type="text"
                                :error-messages="errors.surname"
                            />
                            <v-text-field
                                v-model="form.patronymic"
                                label="Отчество"
                                required
                                type="text"
                                :error-messages="errors.patronymic"
                            />
                            <v-select
                                v-model="form.role"
                                :items="rolesArray"
                                item-text="text"
                                item-value="value"
                                label="Роль"
                                :error-messages="errors.role"
                            />
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
            <div v-if="isShowCredentials">
                <v-dialog
                    v-model="isShowCredentials"
                    max-width="400"
                >
                    <v-card>
                        <v-card-text class="pt-5 font-weight-medium">
                            <div class="d-flex flex-row align-center justify-center mb-4">
                                <v-icon color="success" class="mr-1">mdi-check</v-icon>
                                <span class="green--text">Пользователь успешно создан</span>
                            </div>
                            <div>
                                <span>ФИО:</span>
                                <span>{{ credentials.abbreviated_name }}</span>
                            </div>
                            <div>
                                <span>Логин:</span>
                                <span>{{ credentials.username }}</span>
                            </div>
                            <div>
                                <span>Пароль:</span>
                                <span>{{ credentials.password }}</span>
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                color="primary"
                                text
                                @click="isShowCredentials = false"
                            >
                                Подтвердить
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </v-row>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'

export default {
    props: {
        roles: Object,
    },
    components: {
        AppLayout
    },
    data () {
        return {
            isShowCredentials: false,
            errors: {},
            credentials: {},
            form: {
                name: '',
                surname: '',
                patronymic: '',
                role: ''
            }
        }
    },
    methods: {
        create() {
            axios.post(this.route('users.store'), this.form)
                .then(response => {
                    this.$refs.createForm.reset()
                    this.credentials = response.data
                    this.isShowCredentials = true
                }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors
                }
            })
        },
    },
    computed: {
        rolesArray () {
            let arr = []
            for (let key in this.roles) {
                arr.push({
                    value: key,
                    text: this.roles[key]
                })
            }
            return arr
        }
    }
}
</script>
