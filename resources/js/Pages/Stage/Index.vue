<template>
    <div>
        <h1 class="title">{{project.name}}</h1>

        <breeze-validation-errors class="has-text-danger mb-3" />

        <ul class="columns stages pb-5">
            <li class="column is-one-third" v-for="stage in stages" v-bind:key="stage.id">
                <stage :stage="stage" :user="auth.user"></stage>
            </li>
        </ul>

        <inertia-link 
            class="mr-5 button is-primary" 
            :href="route('projects.stages.create', {project: project})"
            v-if="auth.user.id == project.created_by" >
            Add Stage
        </inertia-link>

        <inertia-link class="button is-info" :href="route('projects.project-user.index', {project: project})">Members</inertia-link>
    </div>
</template>

<script>

    import Layout from '../../Layouts/Authenticated.vue';
    import Stage from '../../Components/Stage.vue';
    import breezeValidationErrors from '@/Components/ValidationErrors.vue';

    export default {
        layout: Layout,
        props: ['stages', 'project', 'auth'],
        components: {
            stage: Stage,
            breezeValidationErrors,
        },
    }

</script>

<style lang="css" scoped>

    .stages{
        overflow-x: scroll;
    }

    .bugs-wrapper{
        overflow-y: scroll;
        max-height: 50vh;
    }

</style>
