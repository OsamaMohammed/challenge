<template>
    <div>
        <b-table :data="data">
            <b-table-column label="Description" v-slot="props">
                <span class="description">{{ props.row.desc }}</span>
            </b-table-column>
            <b-table-column v-slot="props" width="200">
                <b-button type="is-primary" icon-left="eye" @click="showSnippet(props.row)">View Snippet</b-button>
            </b-table-column>
        </b-table>
        <view-snippet :active.sync="viewSnippetActive" :item="showItem" />
    </div>
</template>

<script>
import axios from "axios";
import ViewSnippet from "./componetns/ViewSnippet.vue";
export default {
    components: { ViewSnippet },
    name: "home-snippets",
    data() {
        return {
            data: [],
            showItem: {},
            viewSnippetActive: false,
        };
    },
    methods: {
        init() {
            axios.get("/api/home/snippets").then(({ data }) => {
                this.data = data;
            });
        },
        showSnippet(item) {
            this.showItem = item;
            this.viewSnippetActive = true;
        },
    },
    created() {
        this.init();
    },
};
</script>

<style>
.description {
    white-space: pre;
}
</style>