Ext.define('Crust.store.EntityTableStore', {
    extend: 'Ext.data.Store',

    model: 'Crust.model.EntityTable',
    autoLoad: true,

    proxy: {
        type: 'rest',
        url: '/~dev/crust/rest.php',

        reader: {
            type: 'json',
            root: 'entity_table'
        }
    }
});

