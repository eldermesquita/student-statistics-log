<template>
    <app-layout title="Ученики">
        <v-card class="mb-5">
            <v-card-title>Панель управления учениками</v-card-title>
            <v-card-text class="d-flex justify-space-between align-center">
                <span>
                    Администраторы могут создавать классы, переводить учеников, а также импортировать учащихся.
                </span>
            </v-card-text>
        </v-card>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout'

export default {
    props: [
        'students',
        'can'
    ],
    components: {
        AppLayout,
    },
    data () {
    },
    methods: {
    }
}
</script>
