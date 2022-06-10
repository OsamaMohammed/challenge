<template>
    <b-modal v-model="modalActive" @close="closeModal">
        <div class="box">
            <label class="subtitle">Description:</label>
            <p class="pl-4">{{ item.desc }}</p>
            <hr />
            <label class="subtitle">Snippet:</label>
            <div class="pl-4" v-html="item.code"></div>
        </div>
    </b-modal>
</template>

<script>
export default {
    name: "view-snippet-modal",
    props: {
        active: {
            default: false,
            type: Boolean,
        },
        item: "",
    },
    data: () => ({
        modalActive: false,
    }),
    methods: {
        closeModal() {
            this.$emit("update:active", false);
        },
    },
    watch: {
        active(newVal) {
            this.modalActive = newVal;
        },
    },
};
</script>
