// Importing plugins
import Vue from "vue";
// Buefy UI Components
import Buefy from "buefy";
Vue.use(Buefy);
// Jodit Editor components
import JoditVue from "jodit-vue";
Vue.use(JoditVue);

// Importing admin components
import PdfResource from "./components/Admin/PdfResource/PdfListing";
import LinkResource from "./components/Admin/LinkResource/LinkListing";
import SnippetResource from "./components/Admin/SnippetResource/SnippetListing";
Vue.component(PdfResource.name, PdfResource);
Vue.component(LinkResource.name, LinkResource);
Vue.component(SnippetResource.name, SnippetResource);

// Importing home components
import homeFiles from "./components/Home/Files";
Vue.component(homeFiles.name, homeFiles);
import homeLinks from "./components/Home/Links";
Vue.component(homeLinks.name, homeLinks);
import homeSnippets from "./components/Home/Snippets";
Vue.component(homeSnippets.name, homeSnippets);

const app = new Vue({
    el: "#app",
});
