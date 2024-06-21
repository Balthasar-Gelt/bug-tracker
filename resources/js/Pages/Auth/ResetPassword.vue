<template>
    <form @submit.prevent="submit">

        <h3 class="title is-3">Reset Password</h3>

        <div class="field">
            <breeze-validation-errors class="has-text-danger" />
        </div>

        <div class="field">
            <label class="label">New Password</label>
            <div class="control">
                <input class="input" type="password" placeholder="Password" v-model="form.password" required
                    autocomplete="new-password" id="password">
            </div>
        </div>

        <div class="field">
            <label class="label">Confirm New Password</label>
            <div class="control">
                <input class="input" type="password" placeholder="Password" v-model="form.password_confirmation"
                    required autocomplete="new-password" id="password_confirmation">
            </div>
        </div>

        <div class="control mt-5">
            <button class="button is-primary" :disabled="form.processing">Reset Password</button>
        </div>
        <a class="is-inline-block mt-3" href="javascript:history.back()">Back</a>
    </form>
</template>

<script>
import Layout from '@/Layouts/Authenticated.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors'

export default {
    layout: Layout,

    components: {
        BreezeValidationErrors,
    },

    props: {
        email: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
