<template>
    <div>
        <h1 v-if="projects.length <= 0" class="has-text-danger is-size-3 has-text-weight-medium">You have no projects yet!</h1>

        <ul v-for="project in projects" v-bind:key="project.id">
            <li :class="[{'has-background-primary-light': project.created_by.id == $page.props.auth.user.id}, 'columns']">
                <inertia-link class="column" :href="route('projects.stages.index', { project: project })">
                    {{ project.name }}
                </inertia-link>

                <div class="column is-flex is-justify-content-flex-start is-align-items-flex-center">
                    <span>Owner:</span>
                    <img :title="project.created_by.name" class="avatar is-28x28 ml-3" :src="project.created_by.icon">
                </div>

                <div class="column columns pb-0 is-mobile">
                    <inertia-link class="column columns pb-0 is-mobile has-text-dark"
                        :href="route('projects.stages.index', { project: project })">
                        <span class="material-icons column is-narrow">bug_report</span>
                        <span class="column">{{ project.bugs_count }}</span>
                    </inertia-link>

                    <inertia-link class="column columns pb-0 is-mobile has-text-dark"
                        :href="route('projects.project-user.index', { project: project })">
                        <span class="material-icons column is-narrow pb-0">people</span>
                        <span class="column pb-0">{{ project.users_count }}</span>
                    </inertia-link>

                </div>

                <p class="column desc">{{ project.short_description }}</p>

                <div class="column links">
                    <inertia-link class="mr-4 has-text-info" :href="route('projects.show', project)">
                        Details
                    </inertia-link>

                    <template v-if="auth.user.id == project.created_by.id">
                        <inertia-link class="mr-4" :href="route('projects.edit', project)">
                            Edit
                        </inertia-link>

                        <inertia-link :onBefore="deleteConfirm" class="has-text-danger"
                            :href="route('projects.destroy', project)" method="delete" type="button">
                            Delete
                        </inertia-link>
                    </template>

                </div>
            </li>
        </ul>

        <inertia-link class="mt-5 button is-primary" :href="route('projects.create')">Add</inertia-link>
    </div>
</template>

<script>

import Layout from '../../Layouts/Authenticated.vue';

export default {
    layout: Layout,
    props: ['projects', 'auth'],
    methods: {
        deleteConfirm() {
            return confirm('Are you sure you want to delete the project?');
        }
    }
}

</script>

<style lang="css" scoped>
ul h2 {
    display: inline-block;
}

ul .desc,
ul h2 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.links {
    text-align: right;
}

.links a:only-child {
    margin-right: 0 !important;
}

.columns:last-child {
    margin-bottom: 0 !important;
}

.columns:not(:last-child) {
    margin-bottom: 0 !important;
}
</style>