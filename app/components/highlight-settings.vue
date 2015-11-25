<template>

    <h1>Highlight Settings</h1>

    <pre>
{{ package.config | json }}
    </pre>

    TODO
</template>

<script>

    module.exports = {

        props: ['package'],

        settings: true,

        methods: {
            save: function () {
               this.$http.post('admin/system/settings/config', {
                   name: 'highlight',
                   config: this.package.config
               }, function () {
                   this.$notify('Settings saved.', '');
               }).error(function (data) {
                   this.$notify(data, 'danger');
               }).always(function () {
                   this.$parent.close();
               });
           }
       }
    };

    window.Extensions.components['highlight-settings'] = module.exports;
</script>
