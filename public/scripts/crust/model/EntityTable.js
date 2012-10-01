Ext.define('Crust.model.EntityTable', {
    extend: 'Ext.data.Model',

    fields: ['name'],
    associations: [{ type: 'hasMany', model: 'Field', name: 'fields'}],

    proxy: {
        type: 'rest',
        url: '/~dev/crust/rest.php'
    }
});
