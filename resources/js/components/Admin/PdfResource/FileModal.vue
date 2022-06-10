<template>
    <b-modal
        v-model="modalActive"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        close-button-aria-label="Close"
        aria-modal
        @close="closeModal"
    >
        <template #default>
            <form @submit.prevent="submit">
                <div class="modal-card" style="width: auto">
                    <header class="modal-card-head">
                        <p class="modal-card-title">{{ isEdit ? "Edit File" : "New File" }}</p>
                        <button type="button" class="delete" @click="closeModal" />
                    </header>
                    <section class="modal-card-body">
                        <!-- Title Input -->
                        <b-field label="Title" :type="errors.title ? 'is-danger' : null" :message="errors.title">
                            <b-input v-model="form.title" type="text" placeholder="Title" required maxlength="255"> </b-input>
                        </b-field>

                        <!-- File Upload Input -->
                        <b-field label="File" :type="errors.file ? 'is-danger' : null" :message="errors.file" v-if="!isEdit">
                            <span class="upload-container">
                                <b-upload v-model="form.file" drag-drop>
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <!-- File already selected -->
                                            <template v-if="form.file">
                                                <p>
                                                    <b-icon icon="file" size="is-large"> </b-icon>
                                                </p>
                                                <p>{{ form.file.name }}</p>
                                            </template>
                                            <!-- Upload new file -->
                                            <template v-else>
                                                <p>
                                                    <b-icon icon="upload" size="is-large"> </b-icon>
                                                </p>
                                                <p>Drop your file here or click to upload</p>
                                            </template>
                                        </div>
                                    </section>
                                </b-upload>
                                <div v-show="form.file" class="delete-btn" @click="form.file = null">
                                    <b-icon icon="delete" type="is-danger"></b-icon>
                                </div>
                            </span>
                        </b-field>

                        <!-- <b-checkbox>Remember me</b-checkbox> -->
                    </section>
                    <footer class="modal-card-foot">
                        <b-button label="Close" @click="closeModal" />
                        <b-button native-type="submit" :loading="loading" label="Submit" type="is-primary" />
                    </footer>
                </div>
            </form>
        </template>
    </b-modal>
</template>

<script>
let apiUri = "/api/files";
import axios from "axios";
export default {
    name: "file-modal",
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
            file: null,
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
                    await axios.post(apiUri, this.getFormData());
                    this.$emit("success");
                    this.closeModal();
                } catch (e) {
                    this.errors = e.response?.data?.errors ?? {};
                }
            }
            this.loading = false;
        },
        getFormData() {
            const formData = new FormData();
            formData.append("title", this.form.title);
            formData.append("file", this.form.file);
            return formData;
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