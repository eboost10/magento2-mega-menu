var config = {
    paths: {
        'menuNodes': 'EBoost_Menu/js/nodes',
        'Vue': 'EBoost_Menu/js/lib/vue',
        'vue': 'EBoost_Menu/js/lib/require-vuejs',
        'Vddl': 'EBoost_Menu/js/lib/vddl',
        'vue-select': 'EBoost_Menu/js/lib/vue-select',
        'vue-treeselect': 'EBoost_Menu/js/lib/vue-treeselect',
        'uuid': 'EBoost_Menu/js/lib/uuidv4.min'
    },
    shim: {
        'Vue': { 'exports': 'Vue' }
    },
    config: {
        mixins: {
          "Magento_Ui/js/modal/modal-component": {
            "EBoost_Menu/js/mixins/modal-mixin": true
          }
        }
    },
};
