<template>
    <v-dialog
        v-model="isOpen"
        max-width="400"
    >
        <v-card>
            <v-card-text class="pt-5 font-weight-medium">
                Вы действительно хотите удалить этот предмет, все АКР предмета перейдут во вкладку без предмета?
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="primary"
                    text
                    @click="isOpen = false"
                >
                    Нет
                </v-btn>
                <v-btn
                    color="primary"
                    text
                    @click="remove"
                    :loading="loading"
                >
                    Удалить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

import { EventBus } from "@/event-bus.js";

export default {
    data () {
        return {
            isOpen: false,
            userId: null,
            loading: false
        }
    },
    methods: {
        remove () {
            this.loading = true
            this.$inertia.delete(this.route('courses.destroy', this.userId), {
                onSuccess: () => {
                    this.isOpen = false
                },
                onFinish: () => {
                    this.loading = false
                }
            })
        }
    },
    mounted () {
        EventBus.$on('openDeleteCourseDialog', userId => {
            this.userId = userId
            this.isOpen = true
        })
    }
}
</script>
