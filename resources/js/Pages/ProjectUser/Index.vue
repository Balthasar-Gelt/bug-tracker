<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">Users of project</h3>
        <h4 class="title is-4 has-text-grey-dark">{{ project.name }}</h4>

        <data-table :project="project" :headers="['', 'Name', 'Email', 'Assigned bugs', 'Resolved bugs']"
            :dataColumns="['icon', 'name', 'email', 'assigned_bugs', 'resolved_bugs']"
            :dataUrlString="'projects.users'" />

        <template v-if="auth.user.id == project.created_by.id">

            <div class="field">
                <breeze-validation-errors class="has-text-danger" />
            </div>

            <!-- <div class="field">
                <label class="label">Invite a user to the project</label>
                <div class="select">
                    <select v-model="form.user_id">
                        <option disabled>Select User</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                    </select>
                </div>
            </div> -->

            <div class="control mt-5">
                <button class="button is-primary" :disabled="form.processing">Invite</button>
            </div>

        </template>

    </form>
</template>

<script>

import Layout from '@/Layouts/Authenticated.vue';
import breezeValidationErrors from '@/Components/ValidationErrors.vue';
import DataTable from '../../Components/DataTable.vue';

export default {
    props: ['project', 'users', 'auth'],
    layout: Layout,
    components: {
        breezeValidationErrors,
        DataTable,
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
            if (!this.form.user_id) {
                return;
            }

            this.form.post(this.route('projects.project-user.store', this.project))
        },
        deleteConfirm() {
            return confirm('Are you sure you want to delete the project?');
        }
    }
}

</script>

<style scoped>
.link {
    text-align: right;
}
</style>