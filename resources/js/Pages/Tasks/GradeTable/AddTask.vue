<template>
    <div class="add-task">
        <v-btn
            fab
            x-small
            color="primary"
            class="ml-1"
            @click="isOpen = true"
        >
            <v-icon dark>
                mdi-plus
            </v-icon>
        </v-btn>
        <v-fade-transition>
            <v-card
                class="add-task__form"
                v-if="isOpen"
                v-click-outside="close"
            >
                <v-icon
                    class="add-task__close-btn"
                    @click="close"
                >
                    mdi-close
                </v-icon>
                <v-card-text>
                    <v-form>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    label="Номер"
                                    type="number"
                                    v-model="form.number"
                                    :error-messages="form.errors.number"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field
                                    label="Постфикс"
                                    type="postfix"
                                    v-model="form.postfix"
                                    :error-messages="form.errors.postfix"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-text-field
                            label="Макс. знач."
                            type="number"
                            v-model="form.max_score"
                            :error-messages="form.errors.max_score"
                        >
                        </v-text-field>
                        <v-text-field
                            label="Мин. знач"
                            type="number"
                            v-model="form.min_score"
                            :error-messages="form.errors.min_score"
                        >
                        </v-text-field>
                        <v-btn
                            small
                            class="primary"
                            @click="addTask"
                        >
                            Создать
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-fade-transition>
    </div>
</template>

<script>
export default {
    props: {
        lastNumber: {
            type: Number,
            default: 0
        },
        testId: Number
    },
    data () {
        return {
            isOpen: false,
            form: this.$inertia.form({
                number: this.lastNumber + 1,
                postfix: null,
                max_score: null,
                min_score: 0
            })
        }
    },
    methods: {
        close () {
            this.isOpen = false
        },
        addTask () {
            this.form.post(this.route('tasks.store', this.testId), {
                onSuccess: () => {
                    this.isOpen = false
                }
            })
        }
    }
}
</script>

<style scoped>
    .add-task {
        position: relative;
    }
    .add-task__form {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 240px;
        max-width: 240px;
        z-index: 999;
    }
    .add-task__close-btn {
        position: absolute;
        right: 5px;
        top: 5px
    }
</style>
