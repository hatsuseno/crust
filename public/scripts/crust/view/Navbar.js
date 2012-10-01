Ext.define('Crust.view.Navbar', {
    extend: 'Ext.grid.Panel',
    title: 'Entity types',

    store: Ext.create('Crust.store.EntityTableStore'),

    columns: [{ text: 'Class', dataIndex: 'name', flex: 1 }],

    listeners: {
        itemdblclick: function(panel, record) {
            var modelName = 'Crust.model.runtime.' + record.get('name');
            var gridName = 'Crust.view.runtime.' + record.get('name');

            var fields = [];
            var columns = [];

            Ext.each(record.raw.fields, function(field) {
                fields.push({
                    name: field.name,
                    type: field.type
                });

                columns.push({
                    text: field.name,
                    dataIndex: field.name,
                    editor: 'textfield',
                    flex: 1
                });
            });

            Ext.define(modelName, {
                extend: 'Ext.data.Model',
                fields: fields,
                proxy: {
                    type: 'rest',
                    url: '/~dev/crust/rest.php/' + record.get('name'),

                    reader: {
                        type: 'json',
                        root: 'entities'
                    },

                    writer: {
                        type: 'json',
                        root: record.get('name')
                    }
                }
            });

            Ext.define(gridName, {
                extend: 'Crust.view.Resource',

                columns: columns,

                title: 'Resource ' + record.get('name'),

                store: new Ext.create('Ext.data.Store', {
                    autoLoad: true,
                    model: modelName,

                    proxy: {
                        type: 'rest',
                        url: '/~dev/crust/rest.php/' + record.get('name'),
                        
                        reader: {
                            type: 'json',
                            root: 'entities'
                        },

                        writer: {
                            type: 'json',
                            root: record.get('name')
                        }
                    }
                }),

                plugins: [
                    Ext.create('Ext.grid.plugin.RowEditing', {
                        clicksToEdit: 1,

                        listeners: {
                            edit: function(editor, e) {
                                e.record.commit();
                            }
                        }
                    })
                ]
            });

            Ext.getCmp('resourceview').add({
                title: record.get('name'),
                tabConfig: { closable: true },

                items: [ 
                    Ext.create(gridName)
                ]
            });
        }
    }
});

