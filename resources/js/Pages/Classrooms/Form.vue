<template>
    <v-dialog
        v-model="isOpen"
        max-width="400"
    >
        <v-card v-if="operation === 'remove'">
            <v-card>
                <v-card-text class="pt-5 font-weight-medium">
                    Вы действительно хотите удалить этот класс
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="isOpen = false"
                    >
                        Нет
                    </v-btn>
                    <v-btn
                        color="primary"
                        text
                        @click="remove"
                        :loading="form.processing"
                    >
                        Удалить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-card>
        <v-card v-else>
            <v-card-title>
                <span>Информация о классе</span>
            </v-card-title>
            <v-card-text class="pt-5">
                <v-form class="d-flex align-center flex-wrap justify-center">
                    <v-text-field
                        label="Номер"
                        v-model="form.number"
                        :error-messages="form.errors.number"
                    ></v-text-field>
                    <v-text-field
                        label="Буква"
                        v-model="form.postfix"
                        :error-messages="form.errors.postfix"
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    text
                    color="primary"
                    @click="isOpen = false"
                >
                    Закрыть
                </v-btn>
                <v-btn
                    text
                    v-if="operation === 'create'"
                    color="primary"
                    @click="create"
                    :loading="form.processing"
                >
                    Сохранить
                </v-btn>
                <v-btn
                    text
                    v-if="operation === 'edit'"
                    color="primary"
                    @click="edit"
                    :loading="form.processing"
                >
                    Обновить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import { EventBus } from "@/event-bus.js";

export default {
    components: {
        AppLayout
    },
    data () {
        return {
            isOpen: false,
            operation: null,
            id: null,
            periodId: null,
            form: this.$inertia.form({
                number: '',
                postfix: ''
            })
        }
    },
    watch: {
        isOpen (value) {
            if (!value) {
                this.form.reset()
            }
        }
    },
    methods: {
        create() {
            this.form.post(this.route('classrooms.store', this.periodId), {
                onSuccess: () => this.isOpen = false,
                onFinish: () => this.form.reset()
            })
        },
        edit() {
            this.form.put(this.route('classrooms.update', this.id), {
                onSuccess: () => {
                    this.isOpen = false
                    this.form.reset()
                },
            })
        },
        remove() {
            this.$inertia.delete(this.route('classrooms.destroy', this.id), {
                onSuccess: () => this.isOpen = false
            })
        }
    },
    mounted() {
        EventBus.$on('openClassroomFormModal', (options) => {
            this.isOpen = true
            this.operation = options.operation
            if (options.operation === 'edit') {
                this.form.number = options.data.number
                this.form.postfix = options.data.postfix
            }
            if (options.operation === 'edit' || options.operation === 'remove') {
                this.id = options.id
            }
            if (options.operation === 'create') {
                this.periodId = options.periodId
            }
        })
    }
}
</script>
