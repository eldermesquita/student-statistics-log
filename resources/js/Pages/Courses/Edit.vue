<template>
    <app-layout :title="course.data.title">
        <v-card class="mb-5">
            <v-card-title>Редактирование предмета {{ course.data.title }}</v-card-title>
            <v-card-text>
                <span>
                    Администраторы могут импортировать предметы.
                </span>
            </v-card-text>
        </v-card>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <v-form @submit.prevent="">
                            <v-text-field
                                v-model="form.title"
                                label="Название"
                                required
                                type="text"
                            ></v-text-field>
                            <span>Для того чтобы назначить преподавателей на этот предмет просто начните вводить его ФИО</span>
                            <v-autocomplete
                                v-model="teachers"
                                :items="teachers"
                                chips
                                color="blue-grey lighten-2"
                                label="Назачить перподавателей"
                                item-text="abbreviated_name"
                                item-value="id"
                                multiple
                            >
                                <template v-slot:selection="data">
                                    <v-chip
                                        v-bind="data.attrs"
                                        :input-value="data.selected"
                                        close
                                        @click="data.select"
                                        small
                                    >
                                        {{ data.item.abbreviated_name }}
                                    </v-chip>
                                </template>
                                <template v-slot:item="data">
                                    <template>
                                        <v-list-item-content>
                                            <v-list-item-title>{{ data.item.abbreviated_name }}</v-list-item-title>
                                        </v-list-item-content>
                                    </template>
                                </template>
                            </v-autocomplete>
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

export default {
    props: [
        'course',
    ],
    components: {
        Pagination,
        AppLayout
    },
    data () {
        return {
            teachers: this.course.data.teachers,
            form: this.$inertia.form({
                title: this.course.data.title
            })
        }
    }
}
</script>
