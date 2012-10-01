Ext.application({
    requires: ['Ext.container.Viewport'],

    name: 'Crust',

    appFolder: 'scripts/crust',

    launch: function() {
        Ext.create('Ext.container.Viewport', {
            layout: 'border',

            items: [
                {
                    region: 'north',
                    html: '<h1 class="x-panel-header">Crust!</h1>',
                    border: false,
                    margins: '0'
                },
                Ext.create('Crust.view.Navbar', { region: 'west', width: 150 }),
                Ext.create('Crust.view.Center', { region: 'center' })
            ]
        });
    }
});

