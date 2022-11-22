<template>
    <div id="app-container" :class="getMenuType">
        <topnav />
        <sidebar />
        <main>
            <div class="loading"></div>
            <div class="container-fluid">
                <slot></slot>
            </div>
        </main>
        <footer-component />
    </div>
</template>

<script>
import Sidebar from "../containers/navs/Sidebar.vue";
import Topnav from "../containers/navs/Topnav.vue";
import Footer from "../containers/navs/Footer.vue";
import { Tooltip } from "bootstrap";
import { mapGetters } from "vuex";

export default {
    components: {
        topnav: Topnav,
        sidebar: Sidebar,
        "footer-component": Footer,
    },
    compatConfig: { MODE: 3 },
    data() {
        return {
            show: false,
        };
    },
    computed: {
        ...mapGetters(["getMenuType"]),
    },
    mounted() {
        setTimeout(() => {
            document.body.classList.add("default-transition");
        }, 100);
        new Tooltip(document.body, {
            selector: "[data-bs-toggle='tooltip']",
        });
    },
};
</script>
