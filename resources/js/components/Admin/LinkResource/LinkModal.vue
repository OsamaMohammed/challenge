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
                        <p class="modal-card-title">{{ isEdit ? "Edit Link" : "New Link" }}</p>
                        <button type="button" class="delete" @click="closeModal" />
                    </header>
                    <section class="modal-card-body">
                        <!-- Title Input -->
                        <b-field label="Title" :type="errors.title ? 'is-danger' : null" :message="errors.title">
                            <b-input v-model="form.title" type="text" placeholder="Title" required maxlength="255"> </b-input>
                        </b-field>

                        <!-- Link Input -->
                        <b-field label="link" :type="errors.link ? 'is-danger' : null" :message="errors.link">
                            <b-input v-model="form.link" type="text" placeholder="link" required maxlength="255" icon="earth" />
                        </b-field>

                        <!-- New Tab Checkbox -->
                        <b-checkbox v-model="form.new_tab" true-value="1" false-value="0">Open link in new tab?</b-checkbox>
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
let apiUri = "/api/links";
import axios from "axios";
export default {
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
            link: "",
            new_tab: 1,
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
    created() {
        this.form = { ...this.attributes };
        this.isEdit = false;
    },
};
</script>
