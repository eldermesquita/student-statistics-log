<template>
    <app-layout title="АКР">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item
                :href="route('tests.index')"
                @click.prevent="$inertia.visit(route('tests.index'))">
                АКР
            </v-breadcrumbs-item>
            <v-breadcrumbs-divider>/</v-breadcrumbs-divider>
            <v-breadcrumbs-item disabled>
                Редактирование АКР
            </v-breadcrumbs-item>
        </template>
        <v-card class="mb-5">
            <v-card-title>АКР</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <div>
                    <span class="d-block">
                        Страница для создания АКР.
                    </span>
                </div>
            </v-card-text>
        </v-card>
        <v-card>
            <v-card-title>Основная информация</v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="form.title"
                    :error-messages="form.errors.title"
                    full-width
                    label="Название"
                >
                </v-text-field>
                <v-row>
                    <v-col md="6">
                        <v-select
                            full-width
                            v-model="form.course_id"
                            :items="courses.data"
                            label="Предмет"
                            item-text="title"
                            item-value="id"
                            no-data-text="Предметы не найдены"
                            @change="onChangeCourse"
                            @click:clear="clearCourse"
                            clearable
                            :error-messages="form.errors.course_id"
                        >
                        </v-select>
                    </v-col>
                    <v-col md="6">
                        <v-select
                            full-width
                            v-model="form.teacher_id"
                            :items="teachers"
                            item-text="abbreviated_name"
                            item-value="id"
                            label="Учитель (сначала выберите предмет)"
                            :disabled="isCourseSelectDisabled"
                            :loading="isCourseSelectLoading"
                            no-data-text="Учителя не найдены"
                            clearable
                            :error-messages="form.errors.teacher_id"
                        >
                        </v-select>
                    </v-col>
                </v-row>
                <div class="d-flex align-center">
                    <v-btn
                        class="primary mr-2 d-block"
                        @click="isOpenDialogClassrooms = true"
                    >
                        Выбрать класс
                    </v-btn>
                    <span class="mr-3">Выбранный класс:</span>
                    <v-chip>{{ selectedClassroom.full_name }}</v-chip>
                </div>
                <v-textarea
                    v-model="this.form.description"
                    :error-messages="form.errors.description"
                    full-width
                    label="Описание работы"
                ></v-textarea>
                <v-date-picker
                    v-model="form.passed_at"
                    :show-current="false"
                    locale="ru-RU"
                >
                </v-date-picker>
                <v-btn
                    class="primary mt-6 d-block"
                    @click="submit"
                    :loading="form.processing"
                >
                    Обновить
                </v-btn>
            </v-card-text>
        </v-card>
        <v-dialog
            v-model="isOpenDialogClassrooms"
            max-width="800"
        >
            <v-card>
                <v-card-text class="pt-5">
                    <span>Выберите класс</span>
                    <v-radio-group
                        @change="isOpenDialogClassrooms = false"
                        v-model="form.classroom_id"
                        :error-messages="form.errors.classroom_id"
                    >
                        <v-radio
                            v-for="classroom in classrooms.data"
                            :key="classroom.id"
                            :label="classroom.full_name"
                            :value="classroom.id"
                        ></v-radio>
                    </v-radio-group>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="isOpenDialogClassrooms = false"
                    >
                        Закрыть
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'

export default {
    props: [
        'courses',
        'classrooms',
        'test'
    ],
    components: {
        AppLayout,
    },
    data () {
        return {
            teachers: [],
            isCourseSelectDisabled: true,
            isCourseSelectLoading: false,
            isOpenDialogClassrooms: false,
            form: this.$inertia.form({
                teacher_id: null,
                classroom_id: this.test.data.classroom.id,
                course_id: this.courses.data.find(course => course.id === Number(this.test.data.course.id)) || null,
                title: this.test.data.title,
                description: this.test.data.description,
                passed_at: this.test.data.passed_at
            })
        }
    },
    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ... data,
                    teacher_id: this.getSelectValue(this.form.teacher_id),
                    course_id: this.getSelectValue(this.form.course_id)
                }))
                .put(this.route('tests.update', this.test.data.id))
        },
        clearCourse() {
            this.teachers = []
            this.form.teacher_id = null
        },
        onChangeCourse() {
            this.form.teacher_id = null
            this.loadTeachers()
        },
        loadTeachers() {
            if (this.form.course_id === null) {
                return
            }
            this.isCourseSelectLoading = true
            return axios.get(this.route('courses.teachers', this.form.course_id), {
            }).then(
                response => {
                    this.teachers = response.data
                }
            ).finally(() => {
                this.isCourseSelectDisabled = false
                this.isCourseSelectLoading = false
            })
        },
        getSelectValue(value) {
            return typeof value === 'object' && value !== null ? value.id : value
        },
    },
    computed: {
        selectedClassroom () {
            return this.classrooms.data.find(classroom => classroom.id === this.form.classroom_id) || ''
        }
    },
    async mounted() {
        await this.loadTeachers()
        this.form.teacher_id = this.teachers.find(teacher => teacher.id === Number(this.test.data.teacher.id))
    }
}
</script>
