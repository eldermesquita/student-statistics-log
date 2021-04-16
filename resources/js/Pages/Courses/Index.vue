<template>
    <app-layout title="Предметы">
        <v-card class="mb-5">
            <v-card-title>Панель управления предметами</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <span>
                    Администраторы могут редактировать предметы, а также создавать новые.
                </span>
                <v-btn
                    class="mb-1"
                    color="primary"
                    @click="$inertia.get(route('courses.create'))"
                >
                    Создать предмет
                </v-btn>
            </v-card-text>
        </v-card>
        <v-row >
            <v-col md="6" lg="4" xl="3" v-for="course in courses.data" :key="course.title">
                <v-card>
                    <v-card-title
                        class="pb-1"
                    >{{ course.title }}
                    </v-card-title>
                    <v-card-text class="pb-0">
                        <div class="d-flex flex-row align-center mb-1">
                            <v-icon color="primary" class="mr-1">mdi-file-document</v-icon>
                            <span>{{ course.tests_count }} АКР</span>
                        </div>
                        <div class="d-flex flex-row align-center">
                            <v-icon color="primary" class="mr-1">mdi-clipboard-account</v-icon>
                            <span>{{ course.teachers_count }} учителей</span>
                        </div>
                    </v-card-text>
                    <v-card-actions class="overflow-hidden">
                        <div class="ml-2 d-flex flex-row align-center">
                            <v-icon color="success" class="mr-1">mdi-check</v-icon>
                            <span class="green--text">Активен</span>
                        </div>
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                        >
                            АКР
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$inertia.get(route('courses.edit', course.id))"
                        >
                            Редактиров.
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <Pagination
            :meta="courses.meta"
            link="courses.index"
        />
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import Pagination from "../Shared/Pagination/Pagination";

export default {
    props: [
        'courses',
    ],
    components: {
        Pagination,
        AppLayout
    }
}
</script>
