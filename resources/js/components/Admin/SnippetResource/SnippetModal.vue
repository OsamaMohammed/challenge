<template>
    <b-modal
        v-model="modalActive"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        close-button-aria-label="Close"
        aria-modal
        full-screen
        @close="closeModal"
    >
        <template #default>
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">{{ isEdit ? "Edit Snippet" : "New Snippet" }}</p>
                </header>
                <section class="modal-card-body">
                    <!-- Title Input -->
                    <b-field label="Title" :type="errors.title ? 'is-danger' : null" :message="errors.title">
                        <b-input v-model="form.title" type="text" placeholder="Title" required maxlength="255"> </b-input>
                    </b-field>

                    <!-- Desc Input -->
                    <b-field label="Title" :type="errors.desc ? 'is-danger' : null" :message="errors.desc">
                        <b-input v-model="form.desc" type="textarea" placeholder="Description" required maxlength="255"> </b-input>
                    </b-field>

                    <!-- Code Input -->
                    <b-field label="Post" :type="errors.code ? 'is-danger' : null" :message="errors.code">
                        <jodit-editor v-model="form.code" :buttons="getButtons" :config="getOptions" />
                    </b-field>
                </section>
                <footer class="modal-card-foot">
                    <b-button label="Close" @click="closeModal" />
                    <b-button :loading="loading" label="Submit" type="is-primary" @click="submit" />
                </footer>
            </div>
        </template>
    </b-modal>
</template>

<script>
let apiUri = "/api/snippets";
import axios from "axios";
import jodit from "./jodit-config";
// import Editor from "./Editor.vue";
export default {
    // components: { Editor },
    name: "link-modal",
    props: {
        active: {
            default: false,
            type: Boolean,
        },
        editItem: {
            default: null,
            type: Object,
        },
    },
    data: () => ({
        modalActive: false,
        form: {},
        loading: false,
        attributes: {
            title: "",
            code: "",
        },
        isEdit: false,
        errors: {},
    }),
    methods: {
        closeModal() {
            this.$emit("update:active", false);
            this.form = { ...this.attributes };
            this.errors = {};
        },
        async submit() {
            this.loading = true;
            if (this.isEdit) {
                // Submit edit
                try {
                    await axios.put(`${apiUri}/${this.form.id}`, this.form);
                    this.$emit("success");
                    this.closeModal();
                } catch (e) {
                    this.errors = e.response?.data?.errors ?? {};
                }
            } else {
                // Submit new
                try {
                    await axios.post(apiUri, this.form);
                    this.$emit("success");
                    this.closeModal();
                } catch (e) {
                    this.errors = e.response?.data?.errors ?? {};
                }
            }
            this.loading = false;
        },
    },
    watch: {
        active(newVal) {
            this.modalActive = newVal;
        },
        editItem(newVal) {
            if (newVal === null) {
                // New item
                this.form = { ...this.attributes };
                this.isEdit = false;
            } else {
                this.form = { ...newVal };
                this.isEdit = true;
            }
        },
    },
    computed: {
        getButtons() {
            return jodit.buttons;
        },
        getOptions() {
            return jodit.options;
        },
    },
    created() {
        this.form = { ...this.attributes };
        this.isEdit = false;
    },
};
</script>

<style>
.upload-container {
    position: relative;
    display: block;
}
.upload-container .delete-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
    cursor: pointer;
}
</style>