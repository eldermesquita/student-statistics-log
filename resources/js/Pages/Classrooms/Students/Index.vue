<template>
    <app-layout title="Ученики">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item
                :href="route('classrooms.index')"
                @click.prevent="$inertia.visit(route('classrooms.index'))">
                Классы
            </v-breadcrumbs-item>
            <v-breadcrumbs-divider>/</v-breadcrumbs-divider>
            <v-breadcrumbs-item disabled>
                Ученики {{ classroom.number }}{{ classroom.postfix }}
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
                :items="students.data"
                :server-items-length="students.meta.total"
                :options.sync="options"
                :items-per-page="students.meta.per_page"
                :page="students.meta.current_page"
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
                no-data-text="Ученики не найдены."
            >
                <template v-slot:top>
                    <div class="pt-3 pl-3">
                        <v-btn
                            color="primary"
                            dark
                            @click="create"
                        >
                            Добавить ученика
                        </v-btn>
                    </div>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="edit(item.id, item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        class="mr-2"
                        @click="remove(item.id)"
                    >
                        mdi-delete
                    </v-icon>
                    <v-btn
                        small
                        @click="transfer(item.id)"
                    >
                        Перевести
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <Form />
        <Transfer :classrooms="classrooms" />
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import {EventBus} from "../../../event-bus";
import Form from "./Form";
import Transfer from "./Transfer";

export default {
    props: [
        'students',
        'classroom',
        'classrooms'
    ],
    components: {
        Form,
        Transfer,
        AppLayout,
    },
    data () {
        return {
            loading: false,
            options: {},
            headers: [
                {
                    text: 'ФИО',
                    value: 'name',
                },
                {
                    text: 'Действия',
                    value: 'actions'
                }
            ]
        }
    },
    methods: {
        create() {
            EventBus.$emit('openStudentFormModal', {
                classroom_id: this.classroom.id,
                operation: 'create'
            })
        },
        edit(id, data) {
            EventBus.$emit('openStudentFormModal', {
                id: id,
                operation: 'edit',
                data: data
            })
        },
        remove(id) {
            EventBus.$emit('openStudentFormModal', {
                id: id,
                operation: 'remove',
            })
        },
        transfer(studentId) {
            EventBus.$emit('openTransferDialog', {
                studentId: studentId,
                currentClassroomId: this.classroom.id
            })
        },
        changePage(pagination) {
            this.loading = true;
            this.$inertia.get(this.students.meta.links[pagination].url, {
                onSuccess: () => this.loading = false
            })
        },
    }
}
</script>
