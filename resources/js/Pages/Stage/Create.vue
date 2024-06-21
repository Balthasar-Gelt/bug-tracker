<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">Create Stage</h3>

        <div class="field">
            <breeze-validation-errors class="has-text-danger" />
        </div>

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" placeholder="Name" v-model="form.name" required autofocus id="name">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <label class="radio">
                    <input type="radio" name="question">
                    Yes
                </label>
                <label class="radio">
                    <input type="radio" name="question">
                    No
                </label>
            </div>
        </div>

        <div class="control mt-5">
            <button class="button is-primary" :disabled="form.processing">Submit</button>
        </div>
    </form>
</template>

<script>

import Layout from '@/Layouts/Authenticated.vue';
import breezeValidationErrors from '@/Components/ValidationErrors.vue';

export default {
    props: ['project'],
    layout: Layout,
    components: {
        breezeValidationErrors,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: '',
            })
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('projects.stages.store', { project: this.project }))
        }
    }
}

</script>
