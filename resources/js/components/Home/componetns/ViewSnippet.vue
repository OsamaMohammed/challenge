<template>
    <b-modal v-model="modalActive" @close="closeModal">
        <div class="box relative">
            <div class="pl-4" v-html="item.code"></div>
            <div class="clipboard" @click="copyToClipboard">
                <b-tooltip label="Copy to clipboard" position="is-left">
                    <b-icon icon="clipboard-text" type="is-primary" size="is-medium"></b-icon>
                </b-tooltip>
            </div>
        </div>
    </b-modal>
</template>

<script>
import copy from "copy-to-clipboard";
export default {
    name: "view-snippet-modal",
    props: {
        active: {
            default: false,
            type: Boolean,
        },
        item: {
            default: {},
            type: Object,
        },
    },
    data: () => ({
        modalActive: false,
    }),
    methods: {
        closeModal() {
            this.$emit("update:active", false);
        },
        copyToClipboard() {
            copy(this.item.code);
            this.$buefy.toast.open({
                message: "HTML Code saved to clipboard",
                type: "is-success",
            });
        },
    },
    watch: {
        active(newVal) {
            this.modalActive = newVal;
        },
    },
};
</script>

<style>
.relative {
    position: relative;
}
.clipboard {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 1;
    cursor: pointer;
}
</style>