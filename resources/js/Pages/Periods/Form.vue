<template>
    <v-dialog
        v-model="isOpen"
        max-width="800"
    >
        <v-card v-if="operation === 'remove'">
            <v-card>
                <v-card-text class="pt-5 font-weight-medium">
                    Вы действительно хотите удалить этот учебный год?
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
                <span>
                    Выберите дату начала и окончания учебного года
                </span>
            </v-card-title>
            <v-card-text class="pt-5">
                <v-form class="d-flex align-center flex-wrap justify-center">
                    <v-date-picker
                        v-model="form.started_at"
                        color="green lighten-1"
                        class="mr-5"
                        :show-current="false"
                        locale="ru-RU"
                    ></v-date-picker>
                    <v-date-picker
                        v-model="form.ended_at"
                        color="green lighten-1"
                        header-color="primary"
                        :show-current="false"
                        locale="ru-RU"
                    ></v-date-picker>
                    <div v-show="showValidationErrors">
                        <input-error class="red--text mt-3" :message="form.errors.started_at"></input-error>
                        <input-error class="red--text" :message="form.errors.ended_at"></input-error>
                    </div>
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
import ValidationErrors from "../../Jetstream/ValidationErrors";
import InputError from "../../Jetstream/InputError";

export default {
    components: {
        InputError,
        ValidationErrors,
        AppLayout
    },
    data () {
        return {
            showValidationErrors: false,
            isOpen: false,
            operation: null,
            id: null,
            form: this.$inertia.form({
                started_at: '',
                ended_at: ''
            })
        }
    },
    watch: {
        isOpen (value) {
            if (!value) {
                this.form.reset()
                this.showValidationErrors = false
            }
        }
    },
    methods: {
        create() {
            this.form.post(this.route('periods.store'), {
                onSuccess: () => this.isOpen = false,
                onError: () => this.showValidationErrors = true,
                onFinish: () => this.form.reset()
            })
        },
        edit() {
            this.form.put(this.route('periods.update', this.id), {
                onSuccess: () => {
                    this.isOpen = false
                    this.form.reset()
                },
                onError: () => this.showValidationErrors = true,
            })
        },
        remove() {
            this.$inertia.delete(this.route('periods.destroy', this.id), {
                onSuccess: () => this.isOpen = false
            })
        }
    },
    mounted() {
        EventBus.$on('openPeriodFormModal', (options) => {
            this.isOpen = true
            this.operation = options.operation
            if (options.operation === 'edit') {
                this.form.started_at = options.data.started_at
                this.form.ended_at = options.data.ended_at
            }
            if (options.operation === 'edit' || options.operation === 'remove') {
                this.id = options.id
            }
        })
    }
}
</script>
