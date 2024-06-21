<template>
    <div>
        <h1 style="text-decoration: none;" class="title">{{ project.name }}</h1>

        <hr>

        <section class="mb-5">
            <span class="is-size-4 has-text-dark">Short description</span>
            <p>{{ project.short_description }}</p>
        </section>

        <section class="mb-5">
            <span class="is-size-4 has-text-dark">Description</span>
            <p class="project-description mt-2 content" v-html="project.description"></p>
        </section>

        <section class="mb-5">
            <span class="is-size-4 has-text-dark">Project owner</span>
            <ul>
                <li><span class="has-text-weight-medium">Name:</span> {{ project.created_by.name }}</li>
                <li><span class="has-text-weight-medium">Email:</span> {{ project.created_by.email }}</li>
                <li class="is-flex is-justify-content-flex-start is-align-items-flex-center mb-5">
                    <span class="has-text-weight-medium">Icon:</span>
                    <img :title="project.created_by.name" class="avatar is-28x28 ml-2" :src="project.created_by.icon">
                </li>
            </ul>
        </section>

        <section class="mb-5">
            <span class="is-size-4 has-text-dark">Project users</span>
            <data-table :project="project"
                :headers="['', 'Name', 'Email', 'Assigned bugs', 'Resolved bugs']"
                :dataColumns="['icon', 'name', 'email', 'assigned_bugs', 'resolved_bugs']" :dataUrlString="'projects.users'" />
        </section>

        <hr>

        <section class="mb-5">
            <span class="is-size-4 has-text-dark">Project bugs</span>
            <data-table :project="project"
                :headers="['', 'Name', 'Short description', 'Priority', 'Assignee', 'Is resolved']"
                :dataColumns="['', 'name', 'short_description', ['priority', 'name'], ['assignee', 'email'], 'is_resolved']" :dataUrlString="'projects.bugs'" />
        </section>

        <hr>

        <inertia-link class="mr-4 button is-link" :href="route('projects.edit', project)">
            Edit
        </inertia-link>

        <inertia-link :onBefore="deleteConfirm" class="button is-danger" :href="route('projects.destroy', project)"
            method="delete" as="button" type="button">Delete</inertia-link>

    </div>
</template>

<script>

import Layout from '@/Layouts/Authenticated.vue';
import DataTable from '@/Components/DataTable.vue';

export default {
    layout: Layout,
    components: {
        DataTable,
    },
    props: ['project'],
    methods: {
        deleteConfirm() {
            return confirm('Are you sure you want to delete the project?');
        }
    }
}

</script>
