<template>
    <div>
        <div class="notification is-info" v-if="status">
            {{ status }}
        </div>

        <div class="columns is-centered">
            <form class="box column is-6 px-6 py-5" @submit.prevent="submit">

                <h3 class="title is-3 has-text-centered">Log In</h3>
                
                <div class="field">
                    <breeze-validation-errors class="has-text-danger" />
                </div>

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" placeholder="Email address" v-model="form.email" required autofocus autocomplete="email" id="email">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" type="password" placeholder="Password" v-model="form.password" required autocomplete="current-password" id="password">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="checkbox">
                        <input type="checkbox" v-model="form.remember">
                        Remember me
                        </label>
                    </div>
                </div>

                <div class="field">
                    <inertia-link :href="route('register')">
                        Don't have an account?
                    </inertia-link>
                </div>

                <div class="field">
                    <inertia-link v-if="canResetPassword" :href="route('password.request')">
                        Forgot your password?
                    </inertia-link>
                </div>

                <div class="control mt-5">
                    <button class="button is-primary" :disabled="form.processing">Log In</button>
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
            BreezeValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
