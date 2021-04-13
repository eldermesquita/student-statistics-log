<template>
    <v-app>
        <v-card
            class="mx-auto my-auto col-3"
            min-width="320"
        >
            <v-card-title>Регистрация</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submit">
                    <v-text-field
                        v-model="form.surname"
                        label="Фамилия"
                        required
                        :error-messages="errors.surname"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.name"
                        label="Имя"
                        required
                        :error-messages="errors.name"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.patronymic"
                        label="Отчество"
                        required
                        :error-messages="errors.patronymic"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.email"
                        label="Почта"
                        required
                        type="email"
                        :error-messages="errors.email"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.password"
                        label="Пароль"
                        required
                        type="password"
                        :error-messages="errors.password"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.password_confirmation"
                        label="Повторите пароль"
                        required
                        type="password"
                        :error-messages="errors.password_confirmation"
                    ></v-text-field>
                    <v-btn
                        type="submit"
                        class="mt-3"
                        color="primary"
                        :loading="form.processing"
                        :disabled="form.processing"
                    >
                        Зарегистрироваться
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    surname: '',
                    patronymic: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },
        computed: {
            errors() {
                return this.$page.props.errors
            },
        },
        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
