<template>
    <app-layout title="Периоды обучения">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item disabled>
                Периоды обучения
            </v-breadcrumbs-item>
        </template>
        <v-card class="mb-5">
            <v-card-title>Панель управления учебными годами</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <div>
                    <span class="d-block">
                        Администраторы могут создавать, редактировать учебные годы.
                    </span>
                    <span class="d-block red--text">
                        Внимание удалять учебные годы могут только администраторы, так как это может повлиять на всю систему!
                    </span>
                </div>
            </v-card-text>
        </v-card>
        <v-card>
            <v-data-table
                :headers="headers"
                :items="periods.data"
                :server-items-length="periods.meta.total"
                :options.sync="options"
                :items-per-page="periods.meta.per_page"
                :page="periods.meta.current_page"
                @update:page="changePage"
                :loading="loading"
                :footer-props="{
                showFirstLastPage: true,
                disableItemsPerPage : true,
                itemsPerPageText: 'Кол-во на странице: ',
            }"
                :disable-sort="true"
                disable-sort
                no-data-text="Года обучения не найдены."
            >
                <template v-slot:top>
                    <div class="pt-3 pl-3">
                        <v-btn
                            color="primary"
                            dark
                            @click="create"
                        >
                            Создать учебный год
                        </v-btn>
                    </div>
                </template>
                <template v-slot:item.status="{ item }">
                    <span>{{ statuses[item.status] }}</span>
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
                        @click="remove(item.id)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:item.activate="{ item }">
                    <v-btn
                        small
                        text
                        v-if="item.status !== 'active'"
                        color="primary"
                        @click="activate(item.id)"
                    >
                        Активировать
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <Form></Form>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import { EventBus } from "@/event-bus.js";
import Form from "./Form";

export default {
    props: [
        'periods',
        'statuses'
    ],
    components: {
        Form,
        AppLayout
    },
    data () {
        return {
            loading: false,
            options: {},
            headers: [
                {
                    text: 'Дата начала учебного года',
                    value: 'started_at',
                },
                {
                    text: 'Дата окончания учебного года',
                    value: 'ended_at',
                },
                {
                    text: 'Статус',
                    value: 'status',
                },
                {
                    text: 'Действия',
                    value: 'actions',
                },
                {
                    text: 'Активация',
                    value: 'activate',
                }
            ]
        }
    },
    methods: {
        create() {
            EventBus.$emit('openPeriodFormModal', {
                operation: 'create'
            })
        },
        edit(id, data) {
            EventBus.$emit('openPeriodFormModal', {
                id: id,
                operation: 'edit',
                data: data
            })
        },
        remove(id) {
            EventBus.$emit('openPeriodFormModal', {
                id: id,
                operation: 'remove',
            })
        },
        activate(id) {
            this.$inertia.put(this.route('periods.activate', id))
        },
        changePage(pagination) {
            this.loading = true;
            this.$inertia.get(this.periods.meta.links[pagination].url, {
                onSuccess: () => this.loading = false
            })
        },
    }
}
</script>
