<template>
    <div>
        <ul v-for="project in projects" v-bind:key="project.id">
            <li class="columns">
                <inertia-link class="column" :href="route('projects.stages.index', {project: project})">
                    {{project.name}}
                </inertia-link>

                <div class="column columns is-mobile">

                    <div class="column columns is-mobile">
                        <span class="material-icons column is-narrow">bug_report</span>
                        <span class="column">{{project.bugs_count}}</span>
                    </div>

                    <div class="column columns is-mobile">
                        <span class="material-icons column is-narrow">people</span>
                        <span class="column">{{project.users_count}}</span>
                    </div>

                </div>

                <p class="column desc">{{project.description}}</p>
                
                <div class="column links">
                    <inertia-link class="mr-4" :href="route('projects.show', project)">
                        Details
                    </inertia-link>
                    
                    <template  v-if="auth.user.id == project.created_by">
                        <inertia-link class="mr-4" :href="route('projects.edit', project)">
                            Edit
                        </inertia-link>
                    
                        <inertia-link class="has-text-danger" :href="route('projects.destroy', project)" method="delete" type="button">
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
    }

</script>

<style lang="css">

    ul h2{
        display: inline-block;
    }

    ul .desc, ul h2{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .links{
        text-align: right;
    }

    .columns:last-child{
        margin-bottom: 0 !important;
    }

    .columns:not(:last-child){
        margin-bottom: 0 !important;
    }

</style>