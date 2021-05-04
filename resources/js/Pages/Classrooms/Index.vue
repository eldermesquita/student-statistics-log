<template>
    <app-layout title="Учебные классы">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item disabled>
                Классы
            </v-breadcrumbs-item>
        </template>
        <v-card class="mb-5">
            <v-card-title>Панель управления учебными классами</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <div>
                    <span class="d-block">
                        Администраторы могут создавать классы, переводить учеников, а также импортировать учащихся.
                    </span>
                    <span class="d-block red--text">
                        Классы отображаются в соответствии с активированным учебным годом!
                    </span>
                </div>
            </v-card-text>
        </v-card>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="classrooms.data"
                :server-items-length="classrooms.meta.total"
                :options.sync="options"
                :items-per-page="classrooms.meta.per_page"
                :page="classrooms.meta.current_page"
                @update:page="changePage"
                @click:row=""
                :loading="loading"
                :footer-props="{
                showFirstLastPage: true,
                disableItemsPerPage : true,
                itemsPerPageText: 'Кол-во на странице: ',
                }"
                :disable-sort="true"
                disable-sort
                no-data-text="Классы не найдены"
            >
                <template v-slot:top>
                    <div class="pt-3 pl-3">
                        <v-btn
                            color="primary"
                            dark
                        >
                            Создать класс
                        </v-btn>
                        <v-btn
                            color="primary"
                            dark
                        >
                            Импортировать учеников
                        </v-btn>
                    </div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="$inertia.visit(route('classrooms.students.index', item.id))"
                    >
                        mdi-library
                    </v-icon>
                    <v-icon
                        small
                        class="mr-2"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                    >
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
        </v-card>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'

export default {
    props: [
        'classrooms'
    ],
    components: {
        AppLayout,
    },
    data () {
        return {
            loading: false,
            options: {},
            headers: [
                {
                    text: 'Номер',
                    value: 'number',
                },
                {
                    text: 'Буква',
                    value: 'postfix',
                },
                {
                    text: 'Действия',
                    value: 'actions',
                }
            ]
        }
    },
    methods: {
        changePage(pagination) {
            this.loading = true;
            this.$inertia.get(this.classrooms.meta.links[pagination].url, {
                onSuccess: () => this.loading = false
            })
        },
    }
}
</script>
