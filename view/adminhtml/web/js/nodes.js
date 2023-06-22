define([
    "Vue",
    "Vddl",
    "vue-select",
    "vue-treeselect",
    'uiRegistry',
    "vue!EBoost_Menu/vue/app",
    "vue!EBoost_Menu/vue/field-type/autocomplete",
    "vue!EBoost_Menu/vue/field-type/autocomplete-lazy",
    "vue!EBoost_Menu/vue/field-type/checkbox",
    "vue!EBoost_Menu/vue/field-type/image-upload",
    "vue!EBoost_Menu/vue/field-type/simple-field",
    "vue!EBoost_Menu/vue/field-type/template-list",
    "vue!EBoost_Menu/vue/menu-type",
    "vue!EBoost_Menu/vue/nested-list"
], function(Vue, Vddl, vueSelect, vueTreeselect, registry) {

    return function(config) {
        var dependencies = [];

        if (config.vueComponents && config.vueComponents.length > 0) {
            dependencies = config.vueComponents;
        }

        require(dependencies, function() {
            Vue.use(Vddl);

            Vue.component('v-select', vueSelect.VueSelect);
            Vue.component('treeselect', vueTreeselect.Treeselect);

            var app = new Vue({
                el: config.el || "#eboost-menu",
                data: config.data
            });

            registry.set('vueApp', app);
        });
    }
});
