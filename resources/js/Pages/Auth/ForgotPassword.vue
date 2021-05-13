<template>
    <div>
        <div v-if="status" class="notification is-info">
            {{ status }}
        </div>

        <div class="columns is-centered">
            <form class="box column is-6 px-6 py-5" @submit.prevent="submit">

                <div>
                    Forgot your password? Just let us know your email address and we will email you a password reset link that will allow   you to choose a new one.
                </div>

                <div class="field">
                    <breeze-validation-errors class="has-text-danger" />
                </div>

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" placeholder="Email address" v-model="form.email" required autofocus autocomplete="email" id="email">
                    </div>
                </div>

                <div class="control mt-5">
                    <button class="button is-primary" :disabled="form.processing">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import BreezeGuestLayout from "@/Layouts/Guest"
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeValidationErrors,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    }
</script>
