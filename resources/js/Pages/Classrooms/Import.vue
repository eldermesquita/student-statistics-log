<template>
    <app-layout title="Импорт учеников">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item
                :href="route('classrooms.index')"
                @click.prevent="$inertia.visit(route('classrooms.index'))">
                Классы
            </v-breadcrumbs-item>
            <v-breadcrumbs-divider>/</v-breadcrumbs-divider>
            <v-breadcrumbs-item disabled>
                Импорт учеников
            </v-breadcrumbs-item>
        </template>
        <v-card class="mb-5">
            <v-card-title>Импорт учеников</v-card-title>
        </v-card>
        <v-card>
            <v-card-text>
                <form>
                    <v-text-field
                        v-model="form.start_row"
                        :error-messages="form.errors.start_row"
                        type="number"
                        label="С какой строки в документе начинать импорт?"
                    >
                    </v-text-field>
                    <v-file-input
                        v-model="form.file"
                        :error-messages="form.errors.file"
                        full-width
                        label="Файл импорта"
                    ></v-file-input>
                    <v-checkbox
                        v-model="form.smart_addition"
                        :error-messages="form.errors.smart_addition"
                        label="Умное добавление"
                    ></v-checkbox>
                    <span class="d-block orange--text">
                        Установите флажок если хотите добавлять только тех учеников, которые отсутствуют в системе. Полезно при повторном импорте.
                    </span>
                    <v-btn
                        color="primary"
                        class="mt-5"
                        :loading="form.processing"
                        @click="submit"
                    >
                        Импортировать
                    </v-btn>
                </form>
            </v-card-text>
        </v-card>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
        AppLayout,
    },
    data () {
        return {
            form: this.$inertia.form({
                file: null,
                start_row: 4,
                smart_addition: true
            })
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('students.import'), {
                onFinish: () => this.form.reset()
            })
        }
    }
}
</script>
