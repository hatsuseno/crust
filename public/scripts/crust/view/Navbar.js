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
                    editor: field.type == 'date' ? 'datefield' : 'textfield',
                    flex: 1
                });
            });

            Ext.define(modelName, {
                extend: 'Ext.data.Model',
                fields: fields,
            });

            Ext.define(gridName, {
                extend: 'Crust.view.Resource',

                columns: columns,

                title: 'Resource ' + record.get('name'),

                store: new Ext.create('Ext.data.Store', {
                    autoLoad: true,
                    autoSync: true,
                    model: modelName,

                    proxy: {
                        type: 'rest',
                        url: '/~dev/crust/rest.php/' + record.get('name'),
                        format: 'json',
                        
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
                        clicksToEdit: 2,
                    })
                ]
            });

            var resourceView = Ext.getCmp('resourceview');

            var tab = resourceView.add({
                title: record.get('name'),
                tabConfig: { closable: true },

                layout: 'fit',

                items: [ 
                    Ext.create(gridName)
                ]
            });

            resourceView.setActiveTab(tab);
        }
    }
});

