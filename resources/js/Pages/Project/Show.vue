<template>
    <div>
        <h1 class="title">{{project.name}}</h1>

        <p class="mb-5">{{project.description}}</p>

        <inertia-link class="mr-4 button is-link" :href="route('projects.edit', project)">
            Edit
        </inertia-link>
        
        <inertia-link class="button is-danger" :href="route('projects.destroy', project)" method="delete" as="button" type="button">Delete</inertia-link>

    </div>
</template>

<script>

    import Layout from '@/Layouts/Authenticated.vue';

    export default {
        layout: Layout,
        props: ['project'],
    }

</script>
