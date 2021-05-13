<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">{{project.name}} Users</h3>
    
        <ul class="mt-6 mb-6">
            <li v-for="user in projectUsers" :key="user.id" :value="user.id">
                <ul class="columns">
                    <li class="column">{{user.name}}</li>
                    <li class="column">{{user.email}}</li>
                    <li class="column link" v-if="auth.user.id == project.created_by" >
                        <inertia-link class="has-text-danger" method="delete" :href="route('projects.project-user.destroy', {project: project, project_user: user})">
                            Remove
                        </inertia-link>
                    </li>
                </ul>
            </li>
        </ul>

        <template v-if="auth.user.id == project.created_by">

            <div class="field">
                <breeze-validation-errors class="has-text-danger" />
            </div>

            <div class="field">
                <label class="label">User</label>
                <div class="select">
                    <select v-model="form.user_id">
                        <option disabled>Select User</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                    </select>
                </div>
            </div>

            <div class="control mt-5">
                <button class="button is-primary" :disabled="form.processing">Invite</button>
            </div>

        </template>

    </form>
</template>

<script>

    import Layout from '@/Layouts/Authenticated.vue';
    import breezeValidationErrors from '@/Components/ValidationErrors.vue';

    export default {
        props:['project', 'users', 'projectUsers', 'auth'],
        layout: Layout,
        components: {
             breezeValidationErrors
        },
        data() {
            return {
                form: this.$inertia.form({
                    user_id: '',
                })
            }
        },
        methods: {
            submit() {
                this.form.post(this.route('projects.project-user.store', this.project))
            }
        }
    }

</script>

<style scoped>
    .link{
        text-align: right;
    }
</style>