<template>
    <div class="columns">
        <div class="column is-full">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th v-for="(header, key) in headers" v-bind:key="key">{{ header }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in responseData?.data" v-bind:key="data.id">
                        <td v-for="(column, key) in dataColumns" v-bind:key="key">
                            <img v-if="column == 'icon'" class="avatar is-28x28 ml-2" :src="data.icon">
                            <span v-else>{{ formatData(data, column) }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                <a :href="responseData?.first_page_url" class="pagination-previous"
                    @click.prevent="updateData">First page</a>
                <a :href="responseData?.last_page_url" class="pagination-next" @click.prevent="updateData">Last
                    page</a>
                <ul class="pagination-list">
                    <li v-for="(link, key) in paginationLinks" v-bind:key="key">
                        <a :href="link.url"
                            :class="[{ 'is-current': responseData.current_page == link.label }, 'pagination-link']"
                            @click.prevent="updateData">
                            {{ link.label }}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import pagination from '../Other/pagination';

export default {
    props: ['project', 'linksPerPage', 'headers', 'dataColumns', 'dataUrlString'],
    data() {
        return {
            defaultLinksPerPage: 5,
            responseData: null,
            paginationLinks: [],
        }
    },
    mounted() {
        axios.get(route(this.dataUrlString, { project: this.project }))
            .then((res) => {
                this.responseData = res.data;
                this.paginationLinks = pagination({
                    links: this.cleanLinks(this.responseData.links),
                    current_page: this.responseData.current_page,
                    linksPerPage: this.linksPerPage ?? this.defaultLinksPerPage
                });
            });
    },
    methods: {
        formatData(data, columns) {
            if (!Array.isArray(columns)) {
                return data[columns];
            }

            return columns.reduce((prev, curr) => prev[curr] ?? null, data);
        },
        updateData(e) {
            axios.get(e.target.href)
                .then((res) => {
                    this.responseData = res.data;
                    this.paginationLinks = pagination({
                        links: this.cleanLinks(this.responseData.links),
                        current_page: this.responseData.current_page,
                        linksPerPage: this.linksPerPage ?? this.defaultLinksPerPage
                    });
                });
        },
        cleanLinks(links) {
            let tempLinks = links;
            tempLinks.splice(0, 1);
            tempLinks.splice(tempLinks.length - 1, 1);
            return tempLinks;
        },
    },
}
</script>