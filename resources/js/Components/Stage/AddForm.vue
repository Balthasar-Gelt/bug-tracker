<template>
    <div class="modal">
        <div class="modal-background" @click="$emit('closeAddStageForm')"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Create new stage</p>
                <a @click="$emit('closeAddStageForm')" class="delete" aria-label="close"></a>
            </header>
            <section class="modal-card-body">
                <form @submit.prevent="submit">

                    <div class="field mb-0">
                        <breeze-validation-errors class="has-text-danger" />
                    </div>

                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input v-model="form.name" class="input" type="text" placeholder="Name" required autofocus
                                id="name">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Is Final</label>
                        <div class="control">
                            <label class="radio">
                                <input type="radio" name="is_final" value="1" v-model="form.is_final">
                                Yes
                            </label>
                            <label class="radio">
                                <input type="radio" name="is_final" value="0" v-model="form.is_final">
                                No
                            </label>
                        </div>
                        <p class="help">Bugs in this stage will be marked as resolved</p>
                    </div>

                    <div class="control mt-5">
                        <button class="button is-primary" :disabled="form.processing">Submit</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</template>

<script>
import breezeValidationErrors from '@/Components/ValidationErrors.vue';

export default {
    props: ['project'],
    components: {
        breezeValidationErrors,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                is_final: 0,
            })
        }
    },
    mounted() {
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                this.$emit('closeAddStageForm');
            }
        });
    },
    methods: {
        submit() {
            this.form.post(this.route('projects.stages.store', { project: this.project }), {
                onSuccess: () => { this.$emit('closeAddStageForm') }
            })
        }
    },
}
</script>
