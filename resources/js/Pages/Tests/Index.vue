<template>
    <app-layout title="АКР">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item disabled>
                АКР
            </v-breadcrumbs-item>
        </template>
        <v-card class="mb-5">
            <v-card-title>АКР</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <div>
                    <span class="d-block">
                        На этой странице представлен весь список АКР в этом учебном году.
                    </span>
                </div>
            </v-card-text>
        </v-card>
        <v-card class="mb-5">
            <v-card-text>
                <span>Поиск, заполнять все фильтры не обязательно.</span>
                <Search
                    @loading="isLoadingData = true"
                    :params="params"
                    :courses="courses"
                />
            </v-card-text>
        </v-card>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="tests.data"
                :server-items-length="tests.meta.total"
                :options.sync="options"
                :items-per-page="tests.meta.per_page"
                :page="tests.meta.current_page"
                @update:page="changePage"
                :loading="isLoadingData"
                :footer-props="{
                showFirstLastPage: true,
                disableItemsPerPage : true,
                itemsPerPageText: 'Кол-во на странице: ',
                }"
                :disable-sort="true"
                disable-sort
                no-data-text="АКР не найдены."
                loading-text="Идёт загрузка АКР"
            >
                <template v-slot:top>
                    <div class="py-3 px-3">
                        <v-spacer></v-spacer>
                        <v-btn
                            class="primary"
                            @click="$inertia.visit(route('tests.create'))"
                        >
                            Создать АКР
                        </v-btn>
                    </div>
                </template>
                <template v-slot:item.classroom.full_name="{ item }">
                    <span>
                        <v-btn
                            outlined
                            small
                            text
                            @click="$inertia.visit(route('classrooms.students.index', item.classroom.id))"
                        >
                            {{ item.classroom.full_name }}
                        </v-btn>
                    </span>
                </template>
                <template v-slot:item.course.title="{ item }">
                    <span>
                        <v-btn
                            outlined
                            small
                            text
                            @click="$inertia.visit(route('courses.edit', item.course.id))"
                        >
                            {{ item.course.title }}
                        </v-btn>
                    </span>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="$inertia.visit(route('tests.edit', item.id))"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="remove(item.id)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:item.description="{ item }">
                    <span>{{ item.description }}</span>
                </template>
                <template v-slot:item.fill="{ item }">
                    <v-btn
                        small
                        class="primary"
                        @click="$inertia.visit(route('tasks.index', item.id))"
                    >
                        Заполн.
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <DeleteDialog></DeleteDialog>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import Search from "./Forms/Search";
import { EventBus } from "../../event-bus";
import DeleteDialog from "./Forms/DeleteDialog";

export default {
    props: [
        'tests',
        'courses',
        'params'
    ],
    components: {
        Search,
        AppLayout,
        DeleteDialog
    },
    data () {
        return {
            isLoadingData: false,
            options: {},
            teachers: {},
            headers: [
                {
                    text: 'Название',
                    value: 'title',
                },
                {
                    text: 'Описание',
                    value: 'description',
                },
                {
                    text: 'Дата проведения',
                    value: 'passed_at',
                },
                {
                    text: 'Класс',
                    value: 'classroom.full_name'
                },
                {
                    text: 'Предмет',
                    value: 'course.title',
                },
                {
                    text: 'Учитель',
                    value: 'teacher.abbreviated_name',
                },
                {
                    text: 'Действия',
                    value: 'actions',
                },
                {
                    text: 'Заполнение',
                    value: 'fill'
                }
            ]
        }
    },
    methods: {
        changePage(pagination) {
            this.loading = true;
            this.$inertia.get(this.tests.meta.links[pagination].url, {
                onSuccess: () => this.loading = false
            })
        },
        remove(id) {
            EventBus.$emit('openDeleteTestDialog', id)
        }
    }
}
</script>
