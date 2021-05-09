<template>
    <form>
        <v-row>
            <v-col xs="12">
                <v-select
                    v-model="filters.course"
                    :items="courses.data"
                    label="Предмет"
                    item-text="title"
                    item-value="id"
                    no-data-text="Предметы не найдены"
                    @change="onChangeCourse"
                    @click:clear="clearCourse"
                    clearable
                >
                </v-select>
            </v-col>
            <v-col xs="12">
                <v-select
                    v-model="filters.teacher"
                    :items="teachers"
                    item-text="abbreviated_name"
                    item-value="id"
                    label="Учитель (сначала выберите предмет)"
                    :disabled="isCourseSelectDisabled"
                    :loading="isCourseSelectLoading"
                    no-data-text="Учителя не найдены"
                    clearable
                >
                </v-select>
            </v-col>
            <v-col xs="12">
                <v-text-field
                    label="Номер класса"
                    v-model="filters.classroomNumber"
                    clearable
                >
                </v-text-field>
            </v-col>
            <v-col xs="12">
                <v-text-field
                    v-model="filters.classroomPostfix"
                    label="Буква класса"
                    clearable
                >
                </v-text-field>
            </v-col>
        </v-row>
        <v-btn
            class="mt-4 mr-4"
            color="primary"
            @click="search">
            Поиск АКР
        </v-btn>
    </form>
</template>

<script>
export default {
    props: [
        'courses',
        'params',
    ],
    data () {
        return {
            teachers: [],
            isCourseSelectDisabled: true,
            isCourseSelectLoading: false,
            filters: {
                course: this.courses.data.find(course => course.id === Number(this.params.filter.course_id)) || null,
                teacher: this.params.filter.teacher_id,
                classroomNumber: this.params.filter.classroomNumber,
                classroomPostfix: this.params.filter.classroomPostfix,
            },
        }
    },
    methods: {
        onChangeCourse() {
            this.loadTeachers()
        },
        clearCourse() {
            this.teachers = []
            this.filters.teacher = null
        },
        loadTeachers() {
            if (this.filters.course === null) {
                return
            }
            this.isCourseSelectLoading = true
            return axios.get(this.route('courses.teachers', this.getSelectValue(this.filters.course)), {
            }).then(
                response => {
                    this.teachers = response.data
                }
            ).finally(() => {
                this.isCourseSelectDisabled = false
                this.isCourseSelectLoading = false
            })
        },
        search() {
            this.$emit('loading')
            this.$inertia.get(this.route('tests.index'), {
                'filter[course_id]': this.getSelectValue(this.filters.course),
                'filter[teacher_id]': this.getSelectValue(this.filters.teacher),
                'filter[classroomNumber]': this.filters.classroomNumber,
                'filter[classroomPostfix]': this.filters.classroomPostfix
            })
        },
        getSelectValue(value) {
            return typeof value === 'object' && value !== null ? value.id : value
        },
    },
    async mounted() {
        if (this.filters.course !== null) {
            await this.loadTeachers()
            this.filters.teacher = this.teachers.find(teacher => teacher.id === Number(this.params.filter.teacher_id))
        }
    }
}
</script>

<style scoped>

</style>
