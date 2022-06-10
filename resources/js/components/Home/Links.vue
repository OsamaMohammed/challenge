<template>
    <b-table :data="data">
        <b-table-column label="Title" v-slot="props">
            {{ props.row.title }}
        </b-table-column>
        <b-table-column label="Link" v-slot="props">
            <a :href="props.row.link" :target="props.row.new_tab ? '_blank' : ''">
                {{ props.row.link }}
                <b-icon v-show="props.row.new_tab" class="open-in-new" icon="open-in-new" type="is-black" size="is-small"></b-icon>
            </a>
        </b-table-column>
    </b-table>
</template>

<script>
import axios from "axios";
import { saveAs } from "file-saver";
export default {
    name: "home-links",
    data() {
        return {
            data: [],
        };
    },
    methods: {
        init() {
            axios.get("/api/home/links").then(({ data }) => (this.data = data));
        },
        downloadFile(url) {
            axios.get(url, { responseType: "blob" }).then((response) => {
                saveAs(response.data);
            });
        },
    },
    created() {
        this.init();
    },
};
</script>

<style>
.open-in-new {
    opacity: 0.6;
}
</style>