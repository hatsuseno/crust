Ext.define('Crust.view.Resource', {
    extend: 'Ext.grid.Panel',

    tbar: [{
        xtype: 'button',
        text: 'Save changes',
        handler: function() {
            this.up('grid').getStore().commitChanges();
        }
    }, {
        xtype: 'button',
        text: 'Delete item',
        handler: function() {
            var grid = this.up('grid');

            grid.getStore().remove(grid.getSelectionModel().getSelection());
            grid.getStore().commitChanges();
        }
    }],

    listeners: {
        itemdblclick: function(panel, record) {
        }
    }
});

