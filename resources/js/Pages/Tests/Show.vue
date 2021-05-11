<template>
    <app-layout :title="test.title">
        <v-data-table
            :headers="headers"
            :items="desserts"
            class="grades"
            hide-default-footer
        >
            <template v-slot:item.grade="props">
                <InputClickToEdit
                    v-model="props.item.grade"
                    input-class="grades-table__input"
                    text-class="d-block text-center"
                />
            </template>
            <template v-slot:item.iron="props">
                <v-edit-dialog
                    :return-value.sync="props.item.iron"
                    large
                    persistent
                    @save="save"
                    @cancel="cancel"
                    @open="open"
                    @close="close"
                >
                    <div>{{ props.item.iron }}</div>
                    <template v-slot:input>
                        <div class="mt-4 title">
                            Update Iron
                        </div>
                        <v-text-field
                            v-model="props.item.iron"
                            label="Edit"
                            single-line
                            counter
                            autofocus
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
        </v-data-table>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'
import Input from "../../Jetstream/Input";
import InputClickToEdit from "../Tasks/GradeTable/InputClickToEdit";

export default {
    props: [
      'test'
    ],
    components: {
        InputClickToEdit,
        Input,
        AppLayout,
    },
    data () {
        return {
            headers: [
                { text: 'ФИО', value: 'abriviated_name' },
                {
                    text: '1',
                    value: 'grade',
                    sortable: false,
                    width: 60
                },
            ],
            desserts: [
                {
                    grade: 1
                },
                {
                    grade: 1
                },
                {
                    grade: null
                },
                {
                    grade: 1
                },
                {
                    grade: 1
                },
                {
                    grade: null
                },
                {
                    grade: null
                },
                {
                    grade: null
                },
                {
                    grade: 1
                },
                {
                    grade: 1
                },
            ],
            f: {
                student: {
                    id: 1,
                    abbreviated_name: 'Головачев Павел'
                },
                grades: {
                    task_id: 1,
                    grade: 5
                }
            }
        }
    },
    methods: {
        save () {
            this.snack = true
            this.snackColor = 'success'
            this.snackText = 'Data saved'
        },
        cancel () {
            this.snack = true
            this.snackColor = 'error'
            this.snackText = 'Canceled'
        },
        open () {
            this.snack = true
            this.snackColor = 'info'
            this.snackText = 'Dialog opened'
        },
        close () {
            console.log('Dialog closed')
        },
    }
}
</script>
<style lang="css">
    .grades td {
        border-right: thin solid rgba(0,0,0,.12);
        padding: 0 !important;
    }
    .grades-table__input {
        width: 100%;
        outline: none;
        border-top: thin solid rgba(0,0,0,.12);
        border-bottom: thin solid rgba(0,0,0,.12);
        text-align: center;
    }

</style>

