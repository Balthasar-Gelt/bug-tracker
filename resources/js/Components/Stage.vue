<template>
    <div class="card">
        <header class="card-header">
            <p 
                :id="stage.id" 
                v-on:blur="updateStage" 
                v-on:keydown.enter="updateStage" 
                contenteditable="false" 
                class="card-header-title">
                {{stage.name}}
            </p>

            <a 
                v-on:click.prevent="editStage()"
                class="card-header-icon" 
                :href="route('projects.stages.edit', [stage.project, stage])">
                Edit
            </a>

            <inertia-link 
                class="card-header-icon has-text-danger" 
                :href="route('projects.stages.destroy', [stage.project, stage])" 
                method="delete" 
                type="button">
                Delete
            </inertia-link>
        </header>

        <div class="card-content bugs-wrapper">
            <div class="content">
                <bug v-for="bug in stage.bugs" v-bind:key="bug.id" 
                :bug="bug"
                :stage="stage"
                :project="stage.project">
                </bug>
            </div>
        </div>

        <footer class="card-footer">
            <a 
                v-on:click.prevent="updateStagePosition('down')" 
                class="card-footer-item"
                v-if="user.id == stage.project.created_by">
                &lt;
            </a>
            <inertia-link 
                class="card-footer-item" 
                :href="route('projects.stages.bugs.create', [stage.project, stage])">
                New Bug
            </inertia-link>
            <a 
                v-on:click.prevent="updateStagePosition('up')" 
                class="card-footer-item"
                v-if="user.id == stage.project.created_by">
                >
            </a>
        </footer>
    </div>
</template>

<script>

    import Bug from './Bug.vue';

    export default {
        props: ['stage', 'user'],
        components:{
            Bug,
        },
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                }),
                nameElement: '',
            }
        },
        mounted() {

            this.nameElement = document.getElementById(this.stage.id);
        },
        methods: {
            editStage(){

                this.nameElement.setAttribute('contenteditable', true);
                this.nameElement.focus();
            },
            updateStage(){

                this.nameElement.setAttribute('contenteditable', false);

                this.form.name = this.nameElement.innerHTML;
                this.form.patch(this.route('projects.stages.update', [this.stage.project, this.stage]))
            },
            updateStagePosition(operand){

                this.$inertia.patch(this.route(
                    'projects.stages-serial-number.update', {
                        project: this.stage.project, 
                        stages_serial_number: this.stage
                        }), {
                            operator:  operand
                })
            },
        },
    }
</script>
