<template>
    <b-table :data="data">
        <b-table-column label="Title" v-slot="props">
            {{ props.row.title }}
        </b-table-column>
        <b-table-column label="Download" v-slot="props">
            <a @click="downloadFile(props.row.public_path)">Download</a>
        </b-table-column>
    </b-table>
</template>

<script>
import axios from "axios";
import { saveAs } from "file-saver";
export default {
    name: "home-files",
    data() {
        return {
            data: [],
        };
    },
    methods: {
        init() {
            axios.get("/api/home/files").then(({ data }) => (this.data = data));
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
</style>