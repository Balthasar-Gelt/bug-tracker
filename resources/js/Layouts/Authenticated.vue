<template>
<div>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-menu">
                <div class="navbar-end">
                    <inertia-link :href="route('projects.index')" class="navbar-item">Projects</inertia-link>

                    <div class="navbar-item">
                        <div class="buttons">
                            <inertia-link :href="route('logout')" method="post" as="button" class="button is-light">
                                Log Out
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="container">
        <div class="section">
            <slot/>
        </div>
    </main>
</div>
</template>

<style scoped>
.navbar{
    border-bottom: 1px solid whitesmoke;
}
</style>