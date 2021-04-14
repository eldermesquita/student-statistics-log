<template>
    <v-app id="inspire">
        <Notification></Notification>
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <v-list-item
                style="height: 64px"
                class="px-2"
                link
                @click="$inertia.visit(route('dashboard'))"
            >
                <v-list-item-avatar>
                    <v-img :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name"></v-img>
                </v-list-item-avatar>
                <v-list-item-title class="title">
                    {{ $page.props.user.abbreviated_name }}
                </v-list-item-title>
            </v-list-item>

            <v-divider></v-divider>

            <v-list
                dense
                nav
            >
                <v-list-item
                    link
                    @click="$inertia.visit(route('users.index'))"
                >
                    <v-list-item-icon>
                        <v-icon>mdi-account-group</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Пользователи</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item
                    link
                >
                    <v-list-item-icon>
                        <v-icon>mdi-notebook-outline</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Учебные предметы</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="white">
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Журнал АКР</v-toolbar-title>
            <v-spacer></v-spacer>
            <div class="mr-5">
                <RoleChip :key="$page.props.user.role" :role="$page.props.user.role"></RoleChip>
            </div>
            <v-menu
                bottom
                left
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list
                    dense
                    min-width="180"
                >
                    <v-list-item
                        link
                        @click="$inertia.visit(route('profile.show'))"
                    >
                        <v-list-item-title>
                            Настройки аккаунта
                        </v-list-item-title>
                    </v-list-item>

                    <v-list-item
                        link
                        @click="logout"
                    >
                        <v-list-item-title>Выйти</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main class="grey lighten-5">
            <v-container>
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    import RoleChip from "../Pages/Shared/Users/RoleChip";
    import Notification from "../Pages/Shared/Notifications/Notification";

    export default {
        components: {
            RoleChip,
            Notification
        },
        props: {
            title: String,
        },
        watch: {
            title: {
                immediate: true,
                handler(title) {
                    document.title = title
                },
            },
        },
        data() {
            return {
                showingNavigationDropdown: false,
                drawer: null,
            }
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
