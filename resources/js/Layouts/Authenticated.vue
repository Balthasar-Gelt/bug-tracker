<template>
    <div>
        <div ref="notification" id="notification" class="is-invisible fade-out box notification is-success">
            <a @click="hideNotification" class="delete is-small"></a>
            <span id="notification-text"></span>
        </div>

        <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-menu" id="navbar-main">
                    <div class="navbar-end">
                        <inertia-link :href="route('projects.index')" class="navbar-item">Projects</inertia-link>

                        <div :href="route('projects.index')" class="navbar-item">

                            <div class="dropdown is-hoverable">
                                <div class="dropdown-trigger">
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu4">
                                        <img class="avatar is-28x28 mr-1" :src="$page.props.auth.user.icon">

                                        <span>{{ $page.props.auth.user.name }}</span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                                    <div class="dropdown-content">
                                        <inertia-link :href="route('user.settings')" class="dropdown-item"> User
                                            Settings </inertia-link>
                                        <inertia-link :href="route('logout')" method="post" class="dropdown-item">Log
                                            Out</inertia-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                    data-target="navbar-main">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>
        </nav>

        <main class="container is-fullhd">
            <div class="section">
                <slot />
            </div>
        </main>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

let notification = null;
let opacityTimeout = null;
let visibilityTimeout = null;

Inertia.on('finish', (event) => {
    if (!usePage().props.value.message) {
        return;
    }

    if (notification) {
        [opacityTimeout, visibilityTimeout].forEach(timeout => {
            if (timeout) {
                clearTimeout(timeout);
            }
        });

        notification.querySelector('#notification-text').innerHTML = usePage().props.value.message;
        notification.classList.remove('fade-out', 'is-invisible');

        opacityTimeout = setTimeout(() => {
            notification.classList.add('fade-out');

            visibilityTimeout = setTimeout(() => {
                notification.classList.add('is-invisible');
            }, 400);
        }, 2000);
    }
});

export default {
    mounted() {
        notification = document.getElementById('notification');

        document.addEventListener('DOMContentLoaded', () => {

            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Add a click event on each of them
            $navbarBurgers.forEach(el => {
                el.addEventListener('click', () => {

                    // Get the target from the "data-target" attribute
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);
                    // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');

                });
            });

        });
    },
    methods: {
        hideNotification() {
            if (notification) {
                [opacityTimeout, visibilityTimeout].forEach(timeout => {
                    if (timeout) {
                        clearTimeout(timeout);
                    }
                });

                notification.classList.add('fade-out', 'is-invisible');
            }
        }
    }
};
</script>

<style scoped>
.navbar {
    background-color: hsl(0, 0%, 98%);
    border-bottom: 1px solid hsl(0, 0%, 90%);
}
</style>