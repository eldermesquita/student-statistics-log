<template>
    <v-app>
        <v-card
            class="mx-auto my-auto col-3"
            min-width="320"
        >
            <v-card-title>Авторизация</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="submit">
                    <v-text-field
                        v-model="form.username"
                        label="Логин"
                        required
                        :error-messages="errors.username"
                    ></v-text-field>
                    <v-text-field
                        v-model="form.password"
                        label="Пароль"
                        required
                        type="password"
                        :error-messages="errors.password"
                    ></v-text-field>
                    <v-checkbox
                        v-model="form.remember"
                        label="Запомнить меня?"
                    ></v-checkbox>
                    <v-btn
                        type="submit"
                        class="mt-3"
                        color="primary"
                        :loading="form.processing"
                        :disabled="form.processing"
                    >
                        Войти
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
                    username: '',
                    password: '',
                    remember: false
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
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
