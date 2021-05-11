<template>
    <app-layout :title="test.data.title">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs-item
                :href="route('tests.index')"
                @click.prevent="$inertia.visit(route('tests.index'))">
                АКР
            </v-breadcrumbs-item>
            <v-breadcrumbs-divider>/</v-breadcrumbs-divider>
            <v-breadcrumbs-item disabled>
                Заполнение АКР: {{ test.data.title }}
            </v-breadcrumbs-item>
        </template>
        <v-card>
            <v-card-title>
                <span>
                    Заполнение АКР: {{ test.data.title }}
                </span>
                <v-spacer></v-spacer>
                <v-btn
                    class="primary"
                    @click=""
                >
                    Визуализация результ.
                </v-btn>
            </v-card-title>
            <v-card-subtitle>
                Для манипуляциями с заданиями кликните на них левой кнопкой мыши.
            </v-card-subtitle>
            <v-card-text>
                <div class="v-data-table__wrapper">
                    <table class="grade-table text--primary">
                        <tr>
                            <th>№</th>
                            <th class="grade-table__name">ФИО</th>
                            <th v-for="task in tasks.data">
                                <Task
                                    :id="task.id"
                                    :number="task.number"
                                    :postfix="task.postfix"
                                    :min_score="task.min_score"
                                    :max_score="task.max_score"
                                />
                            </th>
                            <th>
                                <span class="vertical-header" style="line-height: 1">Всего <br /> баллов</span>
                            </th>
                            <th class="grade-table__add-task">
                                <AddTask
                                    :test-id="test.data.id"
                                    :last-number="lastNumberTask"
                                />
                            </th>
                        </tr>
                        <tr v-for="(student, index) in students.data">
                            <td>{{ index + 1 }}</td>
                            <td class="grade-table__name">{{ student.name }}</td>
                            <td v-for="(grade, index) in student.grades">
                                <v-text-field
                                    type="number"
                                    v-model="grade.value"
                                    solo
                                    class="elevation-0 grade-table__input"
                                    hide-details
                                    @blur="addGrade(grade)"
                                >
                                </v-text-field>
                            </td>
                        </tr>
                    </table>
                </div>
                <v-btn
                    class="mt-5 primary"
                    @click="saveGrades"
                >
                    Сохранить
                </v-btn>
            </v-card-text>
        </v-card>
    </app-layout>
</template>

<script>

import AppLayout from "../../Layouts/AppLayout";
import AddTask from "./GradeTable/AddTask";
import InputClickToEdit from "./GradeTable/InputClickToEdit";
import ChangeSort from "./GradeTable/ChangeSort";
import Input from "../../Jetstream/Input";
import Task from "./GradeTable/Task";

export default {
    props: [
        'test',
        'tasks',
        'students'
    ],
    components: {
        Task,
        Input,
        ChangeSort,
        InputClickToEdit,
        AddTask,
        AppLayout,
    },
    data() {
        return {
            isEdit: false,
            sumScores: [],
            tempGrades: []
        }
    },
    computed: {
        lastNumberTask() {
            return this.tasks.data.length === 0 ? 0 : this.tasks.data[this.tasks.data.length - 1].number
        }
    },
    methods: {
        addGrade(grade) {
            let existingGrade = this.tempGrades.find(elem => elem.task_id === grade.task_id && elem.student_id === grade.student_id)
            if (existingGrade) {
                existingGrade.value = grade.value
            } else {
                this.tempGrades.push({
                    student_id: grade.student_id,
                    task_id: grade.task_id,
                    value: grade.value
                })
            }
        },
        saveGrades() {
            this.$inertia.put(this.route('grades.update'), {
                grades: this.tempGrades
            }, {
                onFinish: () => {
                    this.tempGrades = []
                },
            })
        },
    }
}
</script>

<style scoped>
.grade-table {
    border-collapse: collapse;
    overflow-x: auto;
}

.grade-table td, th {
    position: relative;
    border: 1px solid black;
    width: 50px;
    min-width: 50px;
}

.grade-table td {
    text-align: center;
}

.vertical-header {
    font-size: .7rem;
    writing-mode: vertical-rl;
}

.grade-table__add-task {
    border: none;
    padding: 0;
}

/deep/ .grade-table__input input {
    text-align: center;
}

/deep/ .grade-table__input input::-webkit-inner-spin-button,
/deep/ .grade-table__input input::-webkit-outer-spin-button {
    -webkit-appearance: none;
}

/deep/ .grade-table__input input {
    -moz-appearance: textfield;
}

/deep/ .grade-table__input .v-input__slot {
    box-shadow: none !important;
}

.grade-table__name  {
    white-space: nowrap;
}

</style>
