(function () {
    tinymce.create('tinymce.plugins.sipexaflow', {

        init: function (editor, url) {
            editor.addCommand('sipexa_flow_embed', function () {
                editor.windowManager.open({
                    title: 'Sipexa Flow',
                    width: 600,
                    height: 220,
                    body: [
                        {type: 'label', text: 'Please enter your Sipexa Flow Form API Key.'},
                        {type: 'label', text: 'If you don\'t know it, login through https://sipexaflow.com to Sipexa Flow,'},
                        {type: 'label', text: 'then go to Design Your Form > Edit > General Settings.'},
                        {type: 'label', text: 'Click "Do you wish to embed this form into your web page?"'},
                        {type: 'label', text: 'Copy API Key'},
                        {type: 'textbox', classes: 'sipexaFlowApiKey', label: 'API Key', value: ''}
                    ],
                    onsubmit: function (e) {
                        jQuery(function ($) {
                            editor.insertContent('[sipexa-flow key="' + $('.mce-sipexaFlowApiKey').val() + '" height="600"]');
                        });
                    }
                });
            });
            editor.addButton('sipexaflow', {
                title: 'Sipexa Flow : Insert Form',
                cmd: 'sipexa_flow_embed',
                image: url + "/logo.png"
            });
        },

        getInfo: function () {
            return {
                longname: 'Sipexa Flow for Wordpress Plugin',
                author: 'Sipexa Flow',
                authorurl: 'https://sipexaflow.com',
                infourl: '',
                version: "1.0.2"
            };
        }
    });

    tinymce.PluginManager.add('sipexaflow', tinymce.plugins.sipexaflow);
})();
