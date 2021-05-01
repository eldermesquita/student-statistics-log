<template>
    <v-dialog
        v-model="isOpen"
        max-width="420"
    >
        <v-card>
            <v-card-title>Выберите роль для пользователя</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-radio-group
                    v-model="selectedRole"
                    column
                    :error-messages="$page.props.errors.role"
                >
                    <v-radio
                        v-for="(role, value) in roles"
                        :label="role"
                        :value="value"
                        :key="value"
                    ></v-radio>
                </v-radio-group>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="isOpen = false"
                >
                    Закрыть
                </v-btn>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="changeRole()"
                    :loading="loading"
                >
                    Сменить роль
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import { EventBus } from "@/event-bus.js";

export default {
    props: {
        roles: Object
    },
    data () {
        return {
            selectedRole: '',
            userRole: null,
            isOpen: false,
            loading: false
        }
    },
    mounted() {
        EventBus.$on('openModalChangeRoleDialog', data => {
            this.userRole = data
            this.isOpen = true
        })
    },
    methods: {
        changeRole() {
            let form = new FormData();
            form.append('_method', 'put')
            form.append('role', this.selectedRole)
            this.loading = true
            this.$inertia.post(this.route('users.role.change', this.userRole.userId), form, {
                onSuccess: () => {
                    this.isOpen = false
                },
                onFinish: () => {
                    this.loading = false
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
