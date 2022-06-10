<template>
    <div>
        <nav class="level">
            <div class="level-left">
                <b-input v-model="searchQuery" type="search" class="level-item" placeholder="Search..." @input="searchHandler" />
            </div>
            <div class="level-right">
                <b-button icon-left="plus-circle" @click="openNewDialog" class="level-item" type="is-primary"> New </b-button>
            </div>
        </nav>
        <b-table
            narrowed
            :current-page="page"
            :data="items"
            :default-sort="[sortField, sortOrder]"
            default-sort-direction="desc"
            :loading="isLoading"
            :per-page="perPage"
            :total="total"
            @page-change="onPageChange"
            @sort="onSort"
            backend-pagination
            backend-sorting
            hoverable
            paginated
        >
            <b-table-column label="ID" field="id" sortable v-slot="props">
                {{ props.row.id }}
            </b-table-column>

            <b-table-column label="Title" v-slot="props">
                {{ props.row.title }}
            </b-table-column>

            <b-table-column label="Created Date" field="created_at" sortable v-slot="props">
                {{ formatDate(props.row.created_at) }}
            </b-table-column>

            <b-table-column width="135" v-slot="props">
                <b-tooltip label="View Snippet">
                    <a @click="openViewDialog(props.row)">
                        <b-icon icon="eye" type="is-success"></b-icon>
                    </a>
                </b-tooltip>
                <b-tooltip label="Edit">
                    <a @click="openEditDialog(props.row)">
                        <b-icon icon="file-document-edit-outline"></b-icon>
                    </a>
                </b-tooltip>
                <b-tooltip label="Delete" type="is-danger">
                    <a @click="deleteItem(props.row.id)">
                        <b-icon icon="delete" type="is-danger"></b-icon>
                    </a>
                </b-tooltip>
            </b-table-column>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon icon="frown" pack="far" size="is-large"></b-icon>
                        </p>
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>
        </b-table>
        <snippet-modal :active.sync="activeModal" :edit-item.sync="editItem" @success="loadTable" />
        <view-snippet-modal :active.sync="viewModal" :item="viewItem"></view-snippet-modal>
    </div>
</template>

<script>
import snippetModal from "./SnippetModal";
import axios from "axios";
import moment from "moment";
import viewSnippetModal from "./ViewSnippetModal.vue";

// Variables
const apiURI = "/api/snippets";
let timeoutIndex = null;
export default {
    name: "snippet-list",
    components: {
        snippetModal,
        viewSnippetModal,
    },
    data() {
        return {
            itemName: "Snippet",
            items: [],
            total: 0,
            perPage: 1,
            page: 1,
            sortField: "created_at",
            sortOrder: "desc",
            searchQuery: "",
            searchStr: "",
            editItem: null,
            isLoading: true,
            stickyHead: true,
            activeModal: false,
            viewItem: "",
            viewModal: false,
        };
    },
    methods: {
        openViewDialog(item) {
            this.viewModal = true;
            this.viewItem = item;
        },
        openNewDialog() {
            this.editItem = null;
            this.activeModal = true;
        },
        openEditDialog(item) {
            this.editItem = item;
            this.activeModal = true;
        },
        searchHandler() {
            if (timeoutIndex) {
                clearTimeout(timeoutIndex);
            }
            timeoutIndex = setTimeout(this.loadTable, 500);
        },
        onPageChange(page) {
            this.page = page;
            this.loadTable();
        },
        onSort(field, order) {
            this.sortField = field;
            this.sortOrder = order;
            this.loadTable();
        },
        async loadTable() {
            this.isLoading = true;
            let params = [
                `page=${this.page}`,
                `sort=${this.sortField}`,
                `order=${this.sortOrder}`,
                this.searchQuery ? `search=${this.searchQuery}` : "",
            ].join("&");
            try {
                let res = await axios.get(apiURI + "?" + params);
                this.items = res.data.data;
                this.total = res.data.total;
                this.page = res.data.current_page;
                this.perPage = res.data.per_page;
            } catch (error) {
                this.items = [];
                this.total = 0;
                this.page = 1;
            }
            this.isLoading = false;
        },
        search() {
            if (this.searchQuery == "") {
                this.searchStr = "";
            } else {
                this.searchStr = "&" + `search=${this.searchQuery}`;
            }
            this.page = 1;
            this.loadTable();
        },
        deleteItem(id) {
            this.$buefy.dialog.confirm({
                title: "Deleting " + this.itemName,
                message: `Are you sure you want to <b>delete</b> this ${this.itemName}? This action cannot be undone.`,
                confirmText: "Delete",
                type: "is-danger",
                hasIcon: true,
                onConfirm: () => {
                    this.isLoading = true;
                    // Send request to server
                    axios
                        .delete(`${apiURI}/${id}`)
                        .then(() => {
                            this.$buefy.toast.open(`${this.itemName} deleted!`, "is-success");
                            this.loadTable();
                        })
                        .catch(() => {
                            this.isLoading = false;
                        });
                },
            });
        },
        formatDate(date) {
            return moment(date).format("YYYY-MM-DD hh:mm");
        },
    },
    mounted() {
        this.loadTable();
    },
    beforeDestroy() {},
};
</script>
