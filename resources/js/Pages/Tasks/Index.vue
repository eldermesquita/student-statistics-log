<template>
    <app-layout>
        <v-card>
            <v-card-text>
                <table class="grade-table">
                    <tr>
                        <th>ФИО</th>
                        <th v-for="task in tasks.data">
                            {{ task.number }}
                        </th>
                        <AddTask
                            class="mt-1"
                        />
                    </tr>
                    <tr v-for="student in students.data">
                        <td>{{ student.name }}</td>
                        <td v-for="grade in student.grades">
                            {{ grade.value }}
                        </td>
                    </tr>
                </table>
            </v-card-text>
        </v-card>
    </app-layout>
</template>

<script>

import AppLayout from "../../Layouts/AppLayout";
import AddTask from "./GradeTable/AddTask";

export default {
    props: [
        'tasks',
        'students'
    ],
    components: {
        AddTask,
        AppLayout
    }
}
</script>

<style scoped>
    .grade-table {
        border-collapse: collapse;
    }
    .grade-table td, th {
        padding: 10px;
        border: 1px solid black;
    }
</style>
