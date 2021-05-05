<template>
    <v-dialog
        v-model="isOpen"
        max-width="800"
    >
        <v-card>
            <v-card-text class="pt-5">
                Выберите класс
                <v-radio-group
                    v-model="form.transfer_id"
                    :error-messages="form.errors.transfer_id"
                >
                    <v-radio
                        v-for="classroom in classrooms"
                        :key="classroom.id"
                        :label="`${classroom.number}${classroom.postfix}`"
                        :value="classroom.id"
                    ></v-radio>
                </v-radio-group>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    text
                    @click="isOpen = false"
                >
                    Отменить
                </v-btn>
                <v-btn
                    color="primary"
                    text
                    @click="transfer"
                    :loading="this.form.process"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import { EventBus } from "@/event-bus.js";

export default {
    props: [
        'classrooms',
    ],
    data () {
        return {
            isOpen: false,
            studentId: null,
            form: this.$inertia.form({
                transfer_id: ''
            })
        }
    },
    methods: {
        transfer () {
            this.form.put(this.route('students.transfer', this.studentId), {
                preserveScroll: true,
                onSuccess: () => {
                    this.isOpen = false
                    this.form.reset()
                }
            })
        }
    },
    mounted () {
        EventBus.$on('openTransferDialog', data => {
            this.studentId = data.studentId
            this.form.transfer_id = data.currentClassroomId
            this.isOpen = true
        })
    }
}
</script>
